<?php

namespace App\Modules\Drivers\Domain\Services;

use App\Modules\Base\Entity\QrEntityBase;
use App\Modules\Drivers\App\Data\DTO\CreateQrTochkaBankDTO;
use App\Modules\Drivers\App\Data\Entities\TochkaBankEntity;
use App\Modules\Drivers\Domain\Interactor\CreateQrInteractor;
use App\Modules\Drivers\Domain\Interface\Service\IPaymentDriverService;

class TochkaBankService implements IPaymentDriverService
{

    public ?CreateQrTochkaBankDTO $createQrTochkaBankDTO;

    public function __construct(
        private CreateQrInteractor $createQrInteractor,
    ) { }


    /**
     * Создаём данные QR код СБП
     *
     * @return TochkaBankEntity
     */
    public function createQr() : QrEntityBase
    {

        /**
        * @var CreateQrTochkaBankDTO
        */
        $dto = $this->createQrTochkaBankDTO;

        return $this->createQrInteractor->execute($dto);
    }

    //установка DTO


    public function setСreateQrTochkaBankDTO(CreateQrTochkaBankDTO $dto)
    {
        $this->createQrTochkaBankDTO = $dto;
    }


}
