<?php

namespace App\Modules\User\App\Data\DTO\User;

use App\Modules\Base\DTO\BaseDTO;
use App\Modules\User\Domain\Models\User;
use App\Modules\User\App\Data\Enums\UserRoleEnum;

final class UpdateUserDTO extends BaseDTO
{
    public function __construct(

        public User $user, //передаваемый user - над которым будет совершаться действие
        public User $userOwner,
        public UserRoleEnum $role,

    ) { }

    public static function make(

        User $user,
        User $userOwner,
        string $role,

    ) : self {

        return new self(

            user: $user,
            userOwner: $userOwner,
            role: UserRoleEnum::from($role),

        );

    }
}

