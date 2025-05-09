<?php

namespace App\Modules\Subscription\Domain\Services;

use App\Modules\Base\DTO\BaseDTO;
use App\Modules\Subscription\App\Data\DTO\SetTariffPackageDTO;
use App\Modules\Subscription\Domain\Interface\Service\ITariffService;
use App\Modules\Subscription\App\Data\DTO\PriceTariffWorkspaceCalculationDTO;
use App\Modules\Subscription\Domain\Interactor\Workspace\PriceTariffWorkspaceCalculationInteractor;

class TariffWorkspaceService implements ITariffService
{

    public function __construct(
        private PriceTariffWorkspaceCalculationInteractor $priceTariffWorkspaceCalculationInteractor
    ) { }


    /**
     * @param SetTariffPackageDTO $dto
     *
     * @return [type]
     */
    public function setTariff(BaseDTO $dto)
    {
        dd(5);
    }

    /**
     * @param PriceTariffWorkspaceCalculationDTO $dto
     *
     * @return array
    */
    public function priceTariffWorkspaceCalculation(BaseDTO $dto) : array
    {
        return $this->priceTariffWorkspaceCalculationInteractor->execute($dto);
    }
}
