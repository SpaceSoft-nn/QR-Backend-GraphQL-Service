<?php

namespace App\Modules\PersonalArea\App\Data\DTO;

use App\Modules\Base\DTO\BaseDTO;
use App\Modules\User\Domain\Models\User;
use App\Modules\PersonalArea\App\Data\ValueObject\PersonalAreaVO;

final class CreatePersonalAreaDTO extends BaseDTO
{
    public function __construct(

        public PersonalAreaVO $personalAreaVO,
        public User $user,

    ) {}

    public static function make(

        PersonalAreaVO $personalAreaVO,
        User $user,

    ) : self {

        return new self(
            personalAreaVO: $personalAreaVO,
            user: $user,
        );

    }
}

