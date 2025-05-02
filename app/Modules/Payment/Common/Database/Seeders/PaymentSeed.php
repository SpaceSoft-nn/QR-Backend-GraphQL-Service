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
        $payment = Payment::factory()->create([
            "name" => "Банки"
        ]);

        // number_id - 1
        $tochkaBank = PaymentMethod::factory()
            ->withPayment($payment)
            ->create([
                "driver_name" => "Точка Банк",
                "png_url" => "https://static.tildacdn.com/tild3033-3137-4838-b139-343161653937/tochka_bank_300.png",
            ]);
    }

}
