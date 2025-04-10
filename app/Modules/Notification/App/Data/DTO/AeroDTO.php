<?php
namespace App\Modules\Notification\App\Data\DTO;

use App\Modules\Notification\App\Data\DTO\Base\BaseDTO;

class AeroDTO extends BaseDTO
{

    public function __construct(
        public readonly string $phone,
        public readonly ?int $code,
    ) { }

    public static function make($phone, $code = null) : self
    {
        return new self(
            phone: $phone,
            code : $code,
        );
    }

}
