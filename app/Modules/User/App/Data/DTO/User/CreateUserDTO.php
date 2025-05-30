<?php

namespace App\Modules\User\App\Data\DTO\User;

use App\Modules\Base\DTO\BaseDTO;
use App\Modules\User\Domain\Models\User;
use App\Modules\User\App\Data\ValueObject\UserVO;
use App\Modules\Base\Error\GraphQLBusinessException;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\PersonalArea\Domain\Models\PersonalArea;

final class CreateUserDTO extends BaseDTO
{
    public function __construct(

        public PersonalArea $personalArea,
        public Organization $organization,
        public User $user,
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

        Organization $organization,
        PersonalArea $personalArea,
        User $user,
        UserVO $userVO,
        ?string $email,
        ?string $phone,

    ) : self {

        return new self(

            organization: $organization,
            personalArea: $personalArea,
            user: $user,
            userVO: $userVO,
            email: $email,
            phone: $phone,

        );

    }
}

