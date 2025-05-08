<?php

namespace App\Modules\Subscription\Domain\Interface\Service;

use App\Modules\Base\DTO\BaseDTO;

interface ITariffService
{
    public function setTariff(BaseDTO $dto);

}
