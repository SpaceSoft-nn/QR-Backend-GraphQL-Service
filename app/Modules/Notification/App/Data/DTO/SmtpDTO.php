<?php
namespace App\Modules\Notification\App\Data\DTO;

use App\Modules\Notification\App\Data\DTO\Base\BaseDTO;

/**
 * @property string $email
 *
 */
class SmtpDTO extends BaseDTO
{
    public function __construct(
        public readonly string $email,
        public readonly ?int $code,
    ) { }


    public static function make(string $email, ?int $code)
    {
        return new self(
            email : $email,
            code : $code
        );
    }
}
