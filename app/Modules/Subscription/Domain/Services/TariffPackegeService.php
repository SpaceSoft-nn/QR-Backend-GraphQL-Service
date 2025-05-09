<?php

namespace App\Modules\Subscription\Domain\Services;

use App\Modules\Base\DTO\BaseDTO;
use App\Modules\Subscription\Domain\Models\TariffPackage;
use App\Modules\Subscription\Domain\Models\SubscriptionPlan;
use App\Modules\Subscription\App\Data\DTO\SetTariffPackageDTO;
use App\Modules\Subscription\Domain\Interface\Service\ITariffService;
use App\Modules\Subscription\Domain\Interactor\Packege\SetTariffPackegeInteractor;

class TariffPackegeService implements ITariffService
{

    public function __construct(
        private SetTariffPackegeInteractor $setTariffPackegeInteractor,
    ) { }


    /**
     * Установка тарифа для subscription
     * @param SetTariffPackageDTO $dto
     *
     * @return SubscriptionPlan
     */
    public function setTariff(BaseDTO $dto) : SubscriptionPlan
    {
        return $this->setTariffPackegeInteractor->execute($dto);
    }
}
