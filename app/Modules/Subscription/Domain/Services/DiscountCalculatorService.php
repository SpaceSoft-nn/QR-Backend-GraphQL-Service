<?php

namespace App\Modules\Subscription\Domain\Services;

use App\Modules\Base\Money\Money;

class DiscountCalculatorService
{
    public static function calculate(Money $price, int $workspace_count): Money
    {
        if($workspace_count <= 10)
        {

            $price = $price->mul(0.9, 2); //10%

        } else if($workspace_count > 10) {

            $price = $price->mul(0.85, 2); //15%

        } else if($workspace_count > 21) {

            $price = $price->mul(0.75, 2); //25%

        } else if($workspace_count > 51) {

            $price = $price->mul(0.65, 2); //35%

        } else if($workspace_count > 101) {

            $price = $price->mul(0.55, 2); //45%
        }

        return $price;
    }
}
