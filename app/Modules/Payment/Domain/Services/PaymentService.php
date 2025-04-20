<?php

namespace App\Modules\Payment\Domain\Services;

use App\Modules\Payment\App\Data\DTO\CreateDriverInfoDTO;
use App\Modules\Payment\App\Data\ValueObject\DriverInfoVO;
use App\Modules\Payment\Domain\Interactor\CreateDriverInfoInteractor;
use App\Modules\Payment\Domain\Interface\Service\IPaymentService;
use App\Modules\Payment\Domain\Models\DriverInfo;

class PaymentService implements IPaymentService
{

    public function __construct(
        private CreateDriverInfoInteractor $createDriverInfoInteractor
    ) { }


    public function createDriverInfo(CreateDriverInfoDTO $dto) : DriverInfo
    {
        return $this->createDriverInfoInteractor->execute($dto);
    }
}
