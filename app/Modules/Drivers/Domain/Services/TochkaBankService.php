<?php

namespace App\Modules\Drivers\Domain\Services;

use App\Modules\Drivers\App\Data\DTO\CreateQrDTO;
use App\Modules\Drivers\Domain\Interactor\CreateQrInteractor;

class TochkaBankService
{

    public function __construct(
        private CreateQrInteractor $createQrInteractor,
    ) { }


    /**
     * Создаём данные QR код СБП
     * @return [type]
     */
    public function createQr()
    {
        return $this->createQrInteractor->execute(new CreateQrDTO());
    }
}
