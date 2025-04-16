<?php

namespace App\Modules\Payment\Common\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Payment\Domain\Models\Payment;


class PaymentSeed extends Seeder
{

    public function run(): void
    {
        $this->createPayment();
    }

    private function createPayment()
    {
        Payment::factory()->create();
    }

}
