<?php

namespace App\Modules\Payment\Domain\Factories;

use App\Modules\Payment\Domain\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Modules\Payment\App\Data\ValueObject\PaymentVO;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {

        $model = PaymentVO::make(
            status: true,
            name: 'Банки',
        );

        return $model->toArrayNotNull();
    }


}
