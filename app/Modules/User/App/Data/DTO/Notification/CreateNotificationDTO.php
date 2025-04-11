<?php

namespace App\Modules\User\App\Data\DTO\Notification;

use App\Modules\Base\DTO\BaseDTO;
use App\Modules\User\Domain\Models\User;
use App\Modules\Base\Error\GraphQLBusinessException;

final class CreateNotificationDTO extends BaseDTO
{
    public function __construct(
        public User $user,
        public ?string $email,
        public ?string $phone,
    ) {

        if(is_null($email) && is_null($phone))
        {
            throw new GraphQLBusinessException('Ошибка при получении email и phone, хотя бы одно поле должно быть заполнено');
        }
    }

    public static function make(

        User $user,
        ?string $email,
        ?string $phone,

    ) : self {

        return new self(
            user: $user,
            email: $email,
            phone: $phone,
        );

    }
}

