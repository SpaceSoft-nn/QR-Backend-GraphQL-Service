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

    public function __construct(

        public string $guard,

        public ?int $timeExpAccessToken = null,

        public ?int $timeExpRefreshToken = null,

    ) {
        $this->timeExpAccessToken = $timeExpAccessToken ?? env("TIME_EXP_ACCESS_TOKEN" , 60);
        $this->timeExpRefreshToken = $timeExpRefreshToken ?? env("TIME_EXP_REFRESH_TOKEN" , 432000);
    }

    public static function make(

        string $guard = 'api',
        ?int $timeExpAccessToken = null,
        ?int $timeExpRefreshToken = null,

    ) : self {

        return new self(
            guard: $guard,
            timeExpAccessToken: $timeExpAccessToken,
            timeExpRefreshToken: $timeExpRefreshToken,
        );
    }

}
