<?php

namespace App\Modules\User\App\Data\DTO\User;

use App\Modules\Base\DTO\BaseDTO;


final class LoginUserDTO extends BaseDTO
{
    public function __construct(
        public ?string $email,
        public ?string $phone,
        public string $password,
    ) { }

    public static function make(

        ?string $email,
        ?string $phone,
        string $password,

    ) : self {

        return new self(
            email: $email,
            phone: $phone,
            password: $password,
        );

    }
}

