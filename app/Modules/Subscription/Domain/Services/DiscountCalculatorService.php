<?php

namespace App\Modules\Subscription\Domain\Services;

use App\Modules\Base\Money\Money;

class DiscountCalculatorService
{
    public static function calculate(Money $price, int $workspace_count): array
    {
        if($workspace_count <= 10)
        {
            $price = $price->mul(0.9, 2); //10%
            return static::mapCollect($price, 10);

        } else if($workspace_count >= 10 && $workspace_count < 20) {

            $price = $price->mul(0.85, 2); //15%
            return static::mapCollect($price, 15);

        } else if($workspace_count >= 20 && $workspace_count < 50) {

            $price = $price->mul(0.75, 2); //25%
            return static::mapCollect($price, 25);

        } else if($workspace_count >= 50 && $workspace_count < 100) {

            $price = $price->mul(0.65, 2); //35%
            return static::mapCollect($price, 35);

        } else if ($workspace_count >= 100) {

            $price = $price->mul(0.55, 2); //45%
            return static::mapCollect($price, 45);

        }

        //для линковщика
        $price = $price->mul(0.55, 2); //45%
        return static::mapCollect($price, 45);

    }

    private static function mapCollect(Money $price, int $discount) : array
    {
        return [
            'price' => $price,
            'discount' => $discount,
        ];
    }
}
