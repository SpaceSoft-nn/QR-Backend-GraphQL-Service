<?php

namespace App\Modules\User\App\Data\DTO\User;

use App\Modules\Base\DTO\BaseDTO;
use App\Modules\User\App\Data\ValueObject\UserVO;
use App\Modules\Base\Error\GraphQLBusinessException;

final class RegistrationUserDTO extends BaseDTO
{
    public function __construct(
        public UserVO $userVO,
        public ?string $email,
        public ?string $phone,
    ) {

        if(is_null($email) && is_null($phone))
        {
            throw new GraphQLBusinessException('Ошибка при получении email и phone, хотя бы одно поле должно быть заполнено');
        }
    }

    public static function make(

        UserVO $userVO,
        ?string $email,
        ?string $phone,

    ) : self {

        return new self(
            userVO: $userVO,
            email: $email,
            phone: $phone,
        );

    }
}

