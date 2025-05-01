<?php

namespace App\Modules\Drivers\Domain\Services;

use App\Modules\Base\DTO\BaseDTO;
use App\Modules\Drivers\App\Data\DTO\CreateQrDTO;
use App\Modules\Drivers\App\Data\Entities\TochkaBankEntity;
use App\Modules\Drivers\Domain\Interactor\CreateQrInteractor;

class TochkaBankService
{

    public function __construct(
        private CreateQrInteractor $createQrInteractor,
    ) { }



    /**
     * Создаём данные QR код СБП
     * @param CreateQrDTO $dto
     *
     * @return TochkaBankEntity
     */
    public function createQr(BaseDTO $dto) : TochkaBankEntity
    {
        return $this->createQrInteractor->execute($dto);
    }
}
