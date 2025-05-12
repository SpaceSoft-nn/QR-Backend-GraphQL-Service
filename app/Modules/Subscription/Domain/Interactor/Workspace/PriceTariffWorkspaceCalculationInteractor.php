<?php

namespace App\Modules\Subscription\Domain\Interactor\Workspace;

use App\Modules\Base\DTO\BaseDTO;
use App\Modules\Base\Money\Money;
use App\Modules\Base\Interactor\BaseInteractor;
use App\Modules\Subscription\App\Data\Enums\MonthTariffEnum;
use App\Modules\Subscription\Domain\Services\DiscountCalculatorService;
use App\Modules\Subscription\App\Data\Entity\CalculateTariffWorkspaceEntity;
use App\Modules\Subscription\App\Data\DTO\PriceTariffWorkspaceCalculationDTO;

class PriceTariffWorkspaceCalculationInteractor extends BaseInteractor
{

    public function __construct(
        private DiscountCalculatorService $serviceDiscount,
    ) {}


    /**
     * @param PriceTariffWorkspaceCalculationDTO $dto
     *
     * @return CalculateTariffWorkspaceEntity
     */
    public function execute(BaseDTO $dto) : CalculateTariffWorkspaceEntity
    {
        return $this->run($dto);
    }


    /**
     * @param PriceTariffWorkspaceCalculationDTO $dto
     *
     * @return CalculateTariffWorkspaceEntity
     */
    protected function run(BaseDTO $dto) : CalculateTariffWorkspaceEntity
    {
        /**
         * Получаем объект enum в зависимости от периода
         * @var MonthTariffEnum
         *
        */
        $monthTariffEnum = MonthTariffEnum::getMonth($dto->period);

        /** @var int */
        $count_workspace = $dto->count_workspace;

        /**
         * Цена за 1 workspace
         * @var Money
         *
        */
        $priceForOneWorkspace = $monthTariffEnum->getPriceForWorkspace();

        /**
         * Получаем общию сумму количество workspace / период (месяц)
         * @var Money
         *
        */
        $price = $priceForOneWorkspace->mul($count_workspace, 2);

        /**
         * Высчитываем сидку в зависимости от количества workspace
         * @var CalculateTariffWorkspaceEntity
        */
        $arrayCalculate = $this->checkPriceDiscount($price, $count_workspace);

        return $this->createCollection($price, new Money($arrayCalculate['price']), $arrayCalculate['discount']);
    }

    private function createCollection(Money $price, Money $price_discount, int $discount) : CalculateTariffWorkspaceEntity
    {
        return CalculateTariffWorkspaceEntity::make(
            price: $price,
            price_discount: $price_discount,
            discount: (string) $discount,
        );
    }

    private function checkPriceDiscount(Money $price, int $count_workspace) : array
    {
        return $this->serviceDiscount->calculate($price, $count_workspace);
    }

}
