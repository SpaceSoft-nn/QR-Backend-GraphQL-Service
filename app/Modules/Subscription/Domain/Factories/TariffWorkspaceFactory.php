<?php

namespace App\Modules\Subscription\Domain\Factories;

use App\Modules\Subscription\App\Data\ValueObject\TariffWorkspaceVO;
use App\Modules\Subscription\App\Data\Enums\MonthTariffEnum;
use App\Modules\Subscription\Domain\Models\TariffWorkspace;
use Illuminate\Database\Eloquent\Factories\Factory;


class TariffWorkspaceFactory extends Factory
{
    protected $model = TariffWorkspace::class;

    public function definition(): array
    {

        $enum = MonthTariffEnum::ONEMONTH;

        $subscriptionVO = TariffWorkspaceVO::make(
            price: $enum->getPriceForWorkspace(),
            price_discount: $enum->getPriceForWorkspace(),
            count_workspace: 1,
            discount: 0,
            description: "Подписка на 1 АРМ",
            period: 1,
        );

        return $subscriptionVO->toArrayNotNull();
    }

}


