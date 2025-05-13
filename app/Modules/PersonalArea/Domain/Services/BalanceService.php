<?php

namespace App\Modules\PersonalArea\Domain\Services;

use App\Modules\Base\DTO\BaseDTO;
use App\Modules\PersonalArea\Domain\Models\BalanceLog;
use App\Modules\PersonalArea\App\Data\DTO\DepositBalanceDTO;
use App\Modules\PersonalArea\App\Data\DTO\WithdrawalBalanceDTO;
use App\Modules\PersonalArea\Domain\Interface\Service\IBalanceService;
use App\Modules\PersonalArea\App\Data\ValueObject\BalanceLog\BalanceLogVO;
use App\Modules\PersonalArea\Domain\Actions\BalanceLog\CreateBalanceLogAction;
use App\Modules\PersonalArea\Domain\Interactor\Balance\DepositBalancePersonalAreaInteractor;
use App\Modules\PersonalArea\Domain\Interactor\Balance\WithdrawalBalancePersonalAreaInteractor;

final class BalanceService implements IBalanceService
{
    public function __construct(
        private DepositBalancePersonalAreaInteractor $depositBalancePersonalAreaInteractor,
        private WithdrawalBalancePersonalAreaInteractor $withdrawalBalancePersonalAreaInteractor,
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
     * @param WithdrawalBalanceDTO $dto
     *
     * @return bool
     */
    public function withdrawal(BaseDTO $dto) : bool
    {
        return $this->withdrawalBalancePersonalAreaInteractor->execute($dto);
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

    public function logBalance(BalanceLogVO $vo) : BalanceLog
    {
        return CreateBalanceLogAction::make($vo);
    }

}
