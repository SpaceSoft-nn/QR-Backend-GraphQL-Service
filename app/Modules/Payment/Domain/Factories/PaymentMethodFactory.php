<?php

namespace App\Modules\Payment\Domain\Factories;

use App\Modules\Payment\Domain\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Modules\Payment\Domain\Models\PaymentMethod;

class PaymentMethodFactory extends Factory
{
    protected $model = PaymentMethod::class;

    public function definition(): array
    {

        return [
            "active" => true,
            "driver_name" => "Test",
            "payment_id" => null,
            "png_url" => null,
        ];

    }

    public function withPayment(Payment $payment): static
    {
        return $this->state(function (array $attributes) use ($payment) {
            return [
                'payment_id' => $payment->id,
            ];
        });

    }


}
