<?php

namespace App\Modules\Subscription\Domain\Services;

use App\Modules\Base\DTO\BaseDTO;
use App\Modules\Subscription\Domain\Models\SubscriptionPlan;
use App\Modules\Subscription\App\Data\DTO\SetTariffWorkspaceDTO;
use App\Modules\Subscription\Domain\Interface\Service\ITariffService;
use App\Modules\Subscription\App\Data\DTO\PriceTariffWorkspaceCalculationDTO;
use App\Modules\Subscription\App\Data\Entity\CalculateTariffWorkspaceEntity;
use App\Modules\Subscription\Domain\Interactor\Workspace\SetTariffWorkspaceInteractor;
use App\Modules\Subscription\Domain\Interactor\Workspace\PriceTariffWorkspaceCalculationInteractor;

class TariffWorkspaceService implements ITariffService
{

    public function __construct(
        private PriceTariffWorkspaceCalculationInteractor $priceTariffWorkspaceCalculationInteractor,
        private SetTariffWorkspaceInteractor $setTariffWorkspaceInteractor
    ) { }


    /**
     * Устанавливаем тариф
     * @param SetTariffWorkspaceDTO $dto
     *
     * @return SubscriptionPlan
     */
    public function setTariff(BaseDTO $dto) : SubscriptionPlan
    {
        return $this->setTariffWorkspaceInteractor->execute($dto);
    }

    /**
     * Подсчет стоимости тарифа от параметров
     * @param PriceTariffWorkspaceCalculationDTO $dto
     *
     * @return CalculateTariffWorkspaceEntity
    */
    public function priceTariffWorkspaceCalculation(BaseDTO $dto) : CalculateTariffWorkspaceEntity
    {
        return $this->priceTariffWorkspaceCalculationInteractor->execute($dto);
    }
}
