<?php

namespace App\Modules\Drivers\Domain\Services\Factory;

class PaymentDriverServiceFactory
{

    public function __construct(
        private TransactionService $transactionService,
    ) { }




    public static function getPaymentDriverService($paymentSystemId, $args) {
        return match($paymentSystemId)
        {

            1 => $transactionService,

            default => throw new InvalidArgumentException(

                "Драйвер [{$paymentSystemId}] не поддерживается"

            )
        }

    }
}
