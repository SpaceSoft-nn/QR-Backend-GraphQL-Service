<?php

namespace App\Modules\Subscription\App\Data\DTO;

use App\Modules\Base\DTO\BaseDTO;
use App\Modules\PersonalArea\Domain\Models\PersonalArea;
use App\Modules\User\Domain\Models\User;

class SetTariffPackageDTO extends BaseDTO
{
    public function __construct(

        public User $user,
        public int $number_id,
        public PersonalArea $personalArea,

    ){ }

    public static function make(

        User $user,
        int $number_id,
        PersonalArea $personalArea,

    ) : self {


        return new self(
            user: $user,
            number_id: $number_id,
            personalArea: $personalArea,
        );
    }

}
