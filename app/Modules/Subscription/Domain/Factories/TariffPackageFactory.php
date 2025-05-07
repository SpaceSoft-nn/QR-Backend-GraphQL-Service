<?php

namespace App\Modules\Subscription\Domain\Factories;

use App\Modules\Subscription\App\Enums\MonthTariffEnum;
use App\Modules\Subscription\Domain\Models\TariffPackage;
use Illuminate\Database\Eloquent\Factories\Factory;


class TariffPackageFactory extends Factory
{
    protected $model = TariffPackage::class;

    public function definition(): array
    {

        $enum = MonthTariffEnum::ONEMONTH;

        return [
            "name_tariff" => "package",
            "price" => 498,
            "payment_limit" => 50,
            "description" => "50 - Оплат на 1 месяц",
            "period" => $enum->getDays(),
        ];
    }

}


