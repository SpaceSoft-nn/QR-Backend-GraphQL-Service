<?php

namespace App\Modules\PersonalArea\App\Data\DTO;

use App\Modules\Base\DTO\BaseDTO;
use App\Modules\User\Domain\Models\User;
use App\Modules\PersonalArea\Domain\Models\PersonalArea;

final class DepositBalanceDTO extends BaseDTO
{
    public function __construct(

        public PersonalArea $personalArea,
        public User $user,

    ) {}

    public static function make(

        PersonalArea $personalArea,
        User $user,

    ) : self {

        return new self(
            personalArea: $personalArea,
            user: $user,
        );

    }
}

