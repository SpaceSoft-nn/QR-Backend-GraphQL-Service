<?php
namespace App\Modules\Notification\App\Data\DTO\Config;

use Exception;

/**
 * DTO конфигна для драйвера Aero
 * @param
 */
class AeroConfigDTO
{
    public function __construct(
        public string $email,
        public string $apiKey,
        public string $sign = 'SMS Aero',
    ) { }

    public function make($email, $apiKey) : self
    {
        if(!$email || !$apiKey) { new Exception('Ошибка конфинга Aero sms при создании AeroConfigDTO', 500); }
        return new self(
            email : $email,
            apiKey : $apiKey
        );
    }
}
