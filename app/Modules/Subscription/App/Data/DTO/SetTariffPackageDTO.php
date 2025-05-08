<?php

namespace App\Modules\Subscription\App\Data\DTO;

use App\Modules\Base\DTO\BaseDTO;
use App\Modules\User\Domain\Models\User;

class SetTariffPackageDTO extends BaseDTO
{
    public function __construct(

        public User $user,
        public int $number_id,
        public string $personal_area_id,

    ){ }

    public static function make(

        User $user,
        int $number_id,
        string $personal_area_id,

    ) : self {


        return new self(
            user: $user,
            number_id: $number_id,
            personal_area_id: $personal_area_id,
        );
    }

}
