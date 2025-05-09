<?php

namespace App\Modules\Subscription\Domain\Interactor\Workspace;

use App\Modules\Base\DTO\BaseDTO;
use App\Modules\Base\Interactor\BaseInteractor;
use App\Modules\Base\Money\Money;
use App\Modules\Subscription\App\Data\Enums\MonthTariffEnum;
use App\Modules\Subscription\Domain\Services\DiscountCalculatorService;
use App\Modules\Subscription\App\Data\DTO\PriceTariffWorkspaceCalculationDTO;

class PriceTariffWorkspaceCalculationInteractor extends BaseInteractor
{

    public function __construct(
        private DiscountCalculatorService $serviceDiscount,
    ) {}


    /**
     * @param PriceTariffWorkspaceCalculationDTO $dto
     *
     * @return array
     */
    public function execute(BaseDTO $dto) : array
    {
        return $this->run($dto);
    }


    /**
     * @param PriceTariffWorkspaceCalculationDTO $dto
     *
     * @return array
     */
    protected function run(BaseDTO $dto) : array
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
         * @var Money
        */
        $price_discount = $this->checkPriceDiscount($price, $count_workspace);

        return $this->createCollection($price, $price_discount);
    }

    private function createCollection(Money $price, Money $price_discount) : array
    {
        return [
            'price' => $price,
            'price_discount' => $price_discount,
        ];
    }

    private function checkPriceDiscount(Money $price, int $count_workspace) : Money
    {
        return $this->serviceDiscount->calculate($price, $count_workspace);
    }

}
