<?php

namespace App\Modules\Subscription\Domain\Services\Base;

use App\Modules\Subscription\Domain\Services\TariffWorkspaceService;
use App\Modules\Subscription\Domain\Exceptions\ErrorFactoryException;

use App\Modules\Subscription\Domain\Interface\Service\ITariffService;
use App\Modules\Subscription\Domain\Services\TariffPackegeService;

class FactoryTariffService
{
    /**
     * Вовзаращет определённый сервис тарифа, в зависимости от имени
     * @param string $name_tariff
     *
     * @return ITariffService
    */
    public function getServiceTariff(string $name_tariff) : ITariffService
    {

        return match($name_tariff) {

            'package' => app(TariffPackegeService::class),
            'workspace' => app(TariffWorkspaceService::class),
            default => throw new ErrorFactoryException('Ошибка при выборе сервиса тарифа, не правильно переданное имя тарифа.', 500),

        };

    }

}
