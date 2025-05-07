<?php

namespace App\Modules\Subscription\Common\Database\Seeders;

use App\Modules\Subscription\App\Enums\MonthTariffEnum;
use App\Modules\Subscription\Domain\Models\TariffPackage;
use Illuminate\Database\Seeder;

final class TariffSeed extends Seeder
{

    public function run(): void
    {
        $this->createDriverInfo();
    }

    private function createDriverInfo()
    {

        TariffPackage::factory()->create([
            "name_tariff" => "package",
            "price" => 498,
            "payment_limit" => 50,
            "description" => "50 Оплат - на 1 месяц",
            "period" => MonthTariffEnum::ONEMONTH,
        ]);

        TariffPackage::factory()->create([
            "name_tariff" => "package",
            "price" => 1398,
            "payment_limit" => 150,
            "description" => "150 Оплат - на 3 месяца",
            "period" => MonthTariffEnum::THREEMONTH,
        ]);

        TariffPackage::factory()->create([
            "name_tariff" => "package",
            "price" => 799,
            "payment_limit" => 100,
            "description" => "100 Оплат - на 1 месяц",
            "period" => MonthTariffEnum::ONEMONTH,
        ]);

        TariffPackage::factory()->create([
            "name_tariff" => "package",
            "price" => 2199,
            "payment_limit" => 300,
            "description" => "300 Оплат - на 3 месяца",
            "period" => MonthTariffEnum::THREEMONTH,
        ]);

        TariffPackage::factory()->create([
            "name_tariff" => "package",
            "price" => 2498,
            "payment_limit" => 500,
            "description" => "500 Оплат - на 3 месяца",
            "period" => MonthTariffEnum::THREEMONTH,
        ]);

        TariffPackage::factory()->create([
            "name_tariff" => "package",
            "price" => 5998,
            "payment_limit" => 1500,
            "description" => "1500 Оплат - на 6 месяцев",
            "period" => MonthTariffEnum::SIXMONTH,
        ]);

        TariffPackage::factory()->create([
            "name_tariff" => "package",
            "price" => 11998,
            "payment_limit" => 4000,
            "description" => "300 Оплат - на 12 месяцев",
            "period" => MonthTariffEnum::TWELVEMONTH,
        ]);

        //

        TariffPackage::factory()->create([
            "name_tariff" => "package",
            "price" => 3998,
            "payment_limit" => 1000,
            "description" => "1000 Оплат - на 3 месяца",
            "period" => MonthTariffEnum::THREEMONTH,
        ]);

        TariffPackage::factory()->create([
            "name_tariff" => "package",
            "price" => 6998,
            "payment_limit" => 2500,
            "description" => "2500 Оплат - на 6 месяцев",
            "period" => MonthTariffEnum::SIXMONTH,
        ]);

        TariffPackage::factory()->create([
            "name_tariff" => "package",
            "price" => 14998,
            "payment_limit" => 6000,
            "description" => "6000 Оплат - на 12 месяцев",
            "period" => MonthTariffEnum::TWELVEMONTH,
        ]);

        //



    }


}
