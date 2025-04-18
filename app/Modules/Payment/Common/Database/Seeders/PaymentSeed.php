<?php

namespace App\Modules\Payment\Common\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Payment\Domain\Models\Payment;
use App\Modules\Payment\Domain\Models\PaymentMethod;

class PaymentSeed extends Seeder
{

    public function run(): void
    {
        $this->createPayment();
    }

    private function createPayment()
    {
        /** @var Payment */
        $payment = Payment::factory()->create();

        PaymentMethod::factory()
            ->withPayment($payment)
            ->create();
    }

}
