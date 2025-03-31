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

        public int $timeExpAccessToken,

        public int $timeExpRefreshToken,

    ) { }

    public static function make(

        string $guard = 'api',
        int $timeExpAccessToken = 15,
        int $timeExpRefreshToken = 60 * 24 * 30,

    ) : self {
        return new self(
            guard: $guard,
            timeExpAccessToken: $timeExpAccessToken,
            timeExpRefreshToken: $timeExpRefreshToken,
        );
    }

}
