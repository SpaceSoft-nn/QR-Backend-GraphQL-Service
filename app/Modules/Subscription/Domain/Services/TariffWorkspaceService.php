<?php

namespace App\Modules\Subscription\Domain\Services;

use App\Modules\Base\DTO\BaseDTO;
use App\Modules\Subscription\Domain\Interface\Service\ITariffService;

class TariffWorkspaceService implements ITariffService
{
    public function setTariff(BaseDTO $dto)
    {
        dd(2);
    }
}
