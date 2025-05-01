<?php

namespace App\Http\Controllers;

use App\Modules\Drivers\App\Data\DTO\CreateQrDTO;
use App\Modules\Drivers\Domain\Services\TochkaBankService;

class TestController extends Controller
{
    public function __invoke(TochkaBankService $serv)
    {
        $status = $serv->createQr(CreateQrDTO::make(
            amount: 0,
            paymentPurpose: "Test",
            qrcType: "dynamic",
            width: null,
            height: null,
            sourceName: "Qr Prosto",
            ttl: 0,
        ));
    }
}

