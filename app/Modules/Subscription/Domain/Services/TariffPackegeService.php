<?php

namespace App\Modules\Subscription\Domain\Services;

use App\Modules\Base\DTO\BaseDTO;
use App\Modules\Subscription\App\Data\DTO\SetTariffPackageDTO;
use App\Modules\Subscription\Domain\Interface\Service\ITariffService;
use App\Modules\Subscription\Domain\Interactor\Packege\SetTariffPackegeInteractor;
use App\Modules\Subscription\Domain\Models\TariffPackage;

class TariffPackegeService implements ITariffService
{

    public function __construct(
        private SetTariffPackegeInteractor $setTariffPackegeInteractor,
    ) { }


    /**
     * @param SetTariffPackageDTO $dto
     *
     * @return TariffPackage
     */
    public function setTariff(BaseDTO $dto) : TariffPackage
    {
        return $this->setTariffPackegeInteractor->execute($dto);
    }
}
