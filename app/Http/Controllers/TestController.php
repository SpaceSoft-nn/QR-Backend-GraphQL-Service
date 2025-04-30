<?php

namespace App\Http\Controllers;

use App\Modules\Drivers\Domain\Services\TochkaBankService;

class TestController extends Controller
{
    public function __invoke(TochkaBankService $serv)
    {
        $status = $serv->createQr();

        dd($status);
    }
}

