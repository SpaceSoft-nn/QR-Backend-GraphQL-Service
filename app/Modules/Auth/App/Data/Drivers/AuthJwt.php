<?php
namespace App\Modules\Auth\App\Data\Drivers;

use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Modules\Auth\Common\Config\AuthConfig;
use App\Modules\Auth\App\Data\DTO\Base\BaseDTO;
use App\Modules\Auth\App\Data\DTO\UserAttemptDTO;
use App\Modules\Auth\App\Data\Entity\TokeJwtEntity;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use App\Modules\Auth\Domain\Interface\AuthInterface;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Nuwave\Lighthouse\Exceptions\AuthorizationException;
use App\Modules\Auth\Domain\Exceptions\Error\LighthouseTokenExpiredException;
use App\Modules\Auth\Domain\Exceptions\Error\LighthouseTokenBlacklistedException;

class AuthJwt implements AuthInterface
{
    private AuthConfig $config;

    public function __construct(
        AuthConfig $config
    ) {
        $this->config = $config;
    }

    public function login(Model $model) : TokeJwtEntity
    {

        JWTAuth::factory()->setTTL($this->config->timeExpAccessToken);
        $accessToken = JWTAuth::fromUser($model);

        $accessRefresh = $this->createRefreshToken($accessToken);

        return $this->respondWithToken($accessToken, $accessRefresh);
    }

    /**
     * @param UserAttemptDTO $dto
     *
     * @return array
     */
    public function attemptUser(BaseDTO $dto) : TokeJwtEntity
    {

        //получаем акссес токен
        $accessToken = $this->createAccessToken($dto->toArray(), $dto->payload);

        //получаем рефрешь токен
        $accessRefresh = $this->createRefreshToken($accessToken);


        return $this->respondWithToken($accessToken, $accessRefresh);

    }


    public function user() : ?Model
    {
        return JWTAuth::setToken($this->getAuthToken())->authenticate();
    }

    //
    public function logout() : bool
    {

        //инвалидируем Access токен + вход user
        auth($this->config->guard)->logout();

        { //инвалидируем refresh token + cookie
            $token = Cookie::get('refresh_token');
            $this->deletedTokenRefresh($token);
        }

        return true;

    }


    /**
     * Обновляем access + refresh токен, если access истёк, обновляем по refresh, если refresh истёк, выкидываем ошибку авторизации
     * @return ?TokeJwtEntity
     */
    public function refresh() : ?TokeJwtEntity
    {

        $tokenAccess = $this->getAuthToken();

        if(is_null($tokenAccess)) {
            throw new TokenInvalidException('В Header не действительный токен.', 401);
        }

        try {

            //user получаем только в том случае, если tokenAccess валидный
            $user = JWTAuth::setToken($tokenAccess)->authenticate();


        } catch (TokenExpiredException $e) {

            $user = null;

        }  catch (TokenBlacklistedException $e) {

            throw new LighthouseTokenBlacklistedException('Токен Access в black list.', 401);
        }


        if($user) {

            //обновляем refresh
            $refreshToken = $this->createRefreshToken(Cookie::get('refresh_token'));

            //обновляем Access токен
            JWTAuth::factory()->setTTL($this->config->timeExpAccessToken); //устанавливаем время для Access токен
            $tokenAccess = JWTAuth::fromUser($user);

        } else {


            //обновляем refresh
            $refreshToken = $this->createRefreshToken(Cookie::get('refresh_token'));

            //получаем user по актульаному refresh токену
            $user = JWTAuth::setToken($refreshToken)->authenticate();

            //устанавливаем время жизни токена access
            JWTAuth::factory()->setTTL($this->config->timeExpAccessToken);

            //получаем новый токен по user
            $tokenAccess = JWTAuth::fromUser($user);

        }

        return $this->respondWithToken($tokenAccess, $refreshToken);
    }

    /**
     * Устанавлвиаем полезную нагрузу в access токен и получаем новый токен
     * @param array $data
     *
     * @return TokeJwtEntity
     */
    public function setPayload(array $data) : TokeJwtEntity
    {

        $tokenAccess = $this->getAuthToken();

        try {

            $user = JWTAuth::parseToken($tokenAccess)->authenticate();

        } catch (TokenExpiredException $e) {
            throw new LighthouseTokenExpiredException('Токен Access истёк.', 401);
        }  catch (TokenBlacklistedException $e) {
            throw new LighthouseTokenBlacklistedException('Токен Access в black list.', 401);
        }

        $newToken = JWTAuth::claims($data)->fromUser($user);

        //инвалидируем старый токен
        $this->deletedTokenAccess($tokenAccess);

        return $this->respondWithToken($newToken, Cookie::get('refresh_token'));
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return TokeJwtEntity
    */
    public function respondWithToken(string $token, string $refreshToken)
    {
        $payloadAccess = JWTAuth::setToken($token)->getPayload();
        $payloadRefresh = JWTAuth::setToken($refreshToken)->getPayload();

        {
            $timestampAcc = $payloadAccess->get('exp'); // Время истечения токена
            $currentTimestampAcc = now()->timestamp; // Текущее время
            // Рассчитываем оставшееся время в минутах
            $expiresInMinutesAcc = ($timestampAcc - $currentTimestampAcc) / 60;
        }

        {

            $timestampRef = $payloadRefresh->get('exp'); // Время истечения токена
            $currentTimestampRef = now()->timestamp; // Текущее время
            // Рассчитываем оставшееся время в минутах
            $expiresInMinutesRef = ($timestampRef - $currentTimestampRef) / 60;
        }

        return TokeJwtEntity::make(
            access_token: $token,
            token_type: 'Bearer JWT',
            expiresInMinutesAcc: $expiresInMinutesAcc,
            expiresInMinutesRef: $expiresInMinutesRef,
        );
    }

        //Private function
    private function createAccessToken(array $credentials, ?array $payload = []) : string
    {

        // Время жизни Access токена (например, 15 минут)
        $jwt = JWTAuth::factory()->setTTL($this->config->timeExpAccessToken);

        /**
         * Что бы claims не выдавал ошибку инспектора
         * @var \Tymon\JWTAuth\JWTGuard $guard
        */
        $guard = auth($this->config->guard);

        if (! $accessToken = $guard->claims($payload)->attempt($credentials) ) {

            throw new AuthorizationException('Не правильный пароль, email или телефон.', 401);

        } else {
            //Инвалидируем преведущий токен
            $this->deletedTokenAccess($this->getAuthToken());
        }

        return $accessToken;
    }

    private function createRefreshToken($token)
    {

        try {

            if(is_null($token)) {
                $user = null;
            } else {
                $user = JWTAuth::setToken($token)->authenticate() ?? null;
            }

        } catch (TokenExpiredException $e) {
            $user = null;
        }


        try {

            if (!$user) {
                //пытаемся извлечь пользовать по Refresh токену
                $user = JWTAuth::setToken(Cookie::get('refresh_token'))->authenticate();

                $this->deletedTokenRefresh(Cookie::get('refresh_token'));
            }


            JWTAuth::factory()->setTTL($this->config->timeExpRefreshToken);

            $user = auth($this->config->guard)->user() ?? $user;

            //получаем токен
            $refreshToken = JWTAuth::fromUser($user);

            //устанавливаем refresh токен в куки
            $this->setCustomCookie($refreshToken);

            return $refreshToken;

        } catch (TokenExpiredException $e) {

            //инвалидируем предыдущий refresh токен
            $this->deletedTokenRefresh(Cookie::get('refresh_token'));

            //если refresh токен истёк, выкидываем из авторизации явно
            auth($this->config->guard)->logout(true);

            throw new LighthouseTokenExpiredException('Время жизни refresh токена истекло.', 401);

        } catch (TokenInvalidException $e) {

            setcookie('refresh_token', '', time() - 3600, "/");
            throw new LighthouseTokenBlacklistedException('Токен refresh недействителен.', 401);

        } catch (JWTException $e) {

            throw new JWTException('Токен refresh отсутствует.', 401);
        }

    }

    /**
     * Инвалидируем access токен
     * @param ?string $token
     *
     * @return bool
     */
    private function deletedTokenAccess(?string $token = null) : bool
    {

        if(!empty($token))
        {
            try {
                //добавляем токен в черный список
                JWTAuth::setToken($token)->invalidate(true);
            } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException  $th) {
                //Токен уже был инвалидирован
            }

        }

        return true;
    }

    /**
     * Инвалидируем refresh токен + очищаем куки
     * @param mixed $token
     *
     * @return bool
     */
    private function deletedTokenRefresh(?string $token = null) : bool
    {
        try {

            if(!empty($token))
            {
                //добавляем токен в черный список
                JWTAuth::setToken($token)->invalidate(true);

                //удаляем куки
                setcookie('refresh_token', '', time() - 3600, "/");
            }

        } catch (\Throwable $th) {
            //удаляем куки
            setcookie('refresh_token', '', time() - 3600, "/");
        }

        return true;
    }

    /**
     * Получаем токен из header
     * @return ?string
     */
    private function getAuthToken() : ?string
    {

        $token = trim(request()->header('Authorization'));
        $token = preg_replace('/^\s*Bearer\s*/i', '', $token); // Удаляем "Bearer" и пробелы в начале
        $token = trim($token);

        return empty($token) ? null : $token;
    }

    /**
     * Устаналиваем куки
     * @return bool
     */
    private function setCustomCookie(string $refreshToken) : bool
    {
        #TODO Вывести эти значение в config - для удобности работы
        $status = setcookie('refresh_token', $refreshToken, [
            'expires' => time() + (10 * 365 * 24 * 60 * 60),
            'path' => "/",
            'domain' => "",
            'secure' => true,
            'httponly' => true,
            'samesite' => 'None',
        ]);

        return $status;
    }


}
