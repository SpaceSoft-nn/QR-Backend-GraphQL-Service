<?php

namespace App\Modules\Payment\Domain\Factories;

use App\Modules\Payment\Domain\Models\DriverInfo;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Modules\Payment\Domain\Models\PaymentMethod;

class DriverInfoFactory extends Factory
{
    protected $model = DriverInfo::class;

    public function definition(): array
    {

        return [
            "key" => $this->faker->word,
            "value" => $this->faker->uuid,
            "payment_method_id" => PaymentMethod::inRandomOrder()->first(),
            "user_organization_id" => null,
        ];
    }


}
