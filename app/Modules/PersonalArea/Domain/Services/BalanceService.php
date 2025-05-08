<?php

namespace App\Modules\PersonalArea\Domain\Services;

use App\Modules\Base\DTO\BaseDTO;
use App\Modules\PersonalArea\Domain\Interface\Service\IBalanceService;

final class PersonalAreaService implements IBalanceService
{
    public function __construct(
    ) { }

    public function deposit(BaseDTO $dto) : bool
    {

        return true;
    }

    public function withdrawal(BaseDTO $dto) : bool
    {
        return true;
    }

    public function adjustment(BaseDTO $dto) : bool
    {
        return true;
    }

}
