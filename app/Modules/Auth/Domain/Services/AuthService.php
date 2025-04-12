<?php
namespace App\Modules\Auth\Domain\Services;

use App\Modules\Auth\App\Data\DTO\Base\BaseDTO;
use App\Modules\Auth\App\Data\Entity\TokeJwtEntity;
use App\Modules\Auth\Domain\Interface\AuthInterface;
use App\Modules\Auth\Domain\Interface\AuthServiceInterface;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Auth\App\Data\DTO\UserAttemptDTO;
use App\Modules\User\Domain\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService implements AuthServiceInterface
{

    public function __construct(

        /** @property AuthJwt */
       public AuthInterface $serviceAuth

    ) {
        $this->serviceAuth = $serviceAuth;
    }

    public function loginUser(User $user) : TokeJwtEntity
    {
        return $this->serviceAuth->login($user);
    }

    /**
     * Вернуть юзера по Bearer токену
     *
     * @return ?Model
    */
    public function getUserAuth() : ?Model
    {
        return $this->serviceAuth->user();
    }

    /**
     * Найти user по данным email/phone/password и вернуть JWT Token
     *
     * @param UserAttemptDTO $dto
     *
     * @return TokeJwtEntity
     */
    public function attemptUserAuth(BaseDTO $dto) : TokeJwtEntity
    {
        return $this->serviceAuth->attemptUser($dto);
    }

    /**
     * Удалить токен
     * @return bool
     */
    public function logout() : bool
    {
        return $this->serviceAuth->logout();
    }

    /**
     * Удаляет актуальный Bearer, присылаем новый.
     * @return ?TokeJwtEntity
     */
    public function refresh() : ?TokeJwtEntity
    {
        return $this->serviceAuth->refresh();
    }

    /**
     * Устанавливаем полезную нагрузку в токен, получаем новый access токен
     * @param array $data
     *
     * @return TokeJwtEntity
     */
    public function setPayload(array $data) : TokeJwtEntity
    {
        /**
         * Что бы инспектор не ругался
         * @var AuthJwt
         * */
        $service = $this->serviceAuth;

        return $service->setPayload($data);
    }

    public function getUserJWT() : ?User
    {
        return JWTAuth::parseToken()->authenticate();
    }

}
