<?php

namespace App\Modules\PersonalArea\Domain\Services;

use App\Modules\Base\DTO\BaseDTO;
use App\Modules\PersonalArea\App\Data\DTO\DepositBalanceDTO;
use App\Modules\PersonalArea\Domain\Interface\Service\IBalanceService;
use App\Modules\PersonalArea\Domain\Interactor\Balance\DepositBalancePersonalAreaInteractor;

final class PersonalAreaService implements IBalanceService
{
    public function __construct(
        private DepositBalancePersonalAreaInteractor $depositBalancePersonalAreaInteractor,
    ) { }

    /**
     * пополнение
     * @param DepositBalanceDTO $dto
     *
     * @return bool
     */
    public function deposit(BaseDTO $dto) : bool
    {
        return $this->depositBalancePersonalAreaInteractor->execute($dto);
    }

    /**
     * списание
     * @param BaseDTO $dto
     *
     * @return bool
     */
    public function withdrawal(BaseDTO $dto) : bool
    {
        return true;
    }

    /**
     * корректировка
     * @param BaseDTO $dto
     *
     * @return bool
     */
    public function adjustment(BaseDTO $dto) : bool
    {
        return true;
    }

}
