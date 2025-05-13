<?php

namespace App\Modules\PersonalArea\App\Data\DTO;

use App\Modules\Base\DTO\BaseDTO;
use App\Modules\Base\Money\Money;
use App\Modules\PersonalArea\Domain\Models\PersonalArea;

final class SetBalanceDTO extends BaseDTO
{
    public function __construct(

        public Money $money,
        public PersonalArea $personalArea,

    ) {}

    public static function make(

        Money $money,
        PersonalArea $personalArea,

    ) : self {

        return new self(
            money: $money,
            personalArea: $personalArea,
        );

    }
}

