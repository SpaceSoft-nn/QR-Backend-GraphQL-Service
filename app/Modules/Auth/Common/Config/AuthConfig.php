<?php
namespace App\Modules\Auth\Common\Config;


/**
 * Класс AuthConfig
 *
 * @property string $guard драйвер использующий для авторизация
 * @property int $age Возраст пользователя
 */
class AuthConfig
{

    private function __construct(

        public string $guard,

        public ?int $timeExpAccessToken = null,

        public ?int $timeExpRefreshToken = null,

    ) { }

    public static function make(

        string $guard = 'api',
        ?int $timeExpAccessToken = null,
        ?int $timeExpRefreshToken = null,

    ) : self {

        $defaultTimeExpAccessToken = empty(env("TIME_EXP_ACCESS_TOKEN" , 60)) ? 60 : env("TIME_EXP_ACCESS_TOKEN" , 60);
        $defaultTimeExpRefreshToken = empty(env("TIME_EXP_REFRESH_TOKEN" , 432000)) ? 432000 : env("TIME_EXP_REFRESH_TOKEN" , 432000);

        if(is_null($timeExpAccessToken)) { $timeExpAccessToken = $defaultTimeExpAccessToken; }
        if(is_null($timeExpRefreshToken)) { $timeExpRefreshToken = $defaultTimeExpRefreshToken; }


        return new self(
            guard: $guard,
            timeExpAccessToken: $timeExpAccessToken,
            timeExpRefreshToken: $timeExpRefreshToken,
        );
    }

}
