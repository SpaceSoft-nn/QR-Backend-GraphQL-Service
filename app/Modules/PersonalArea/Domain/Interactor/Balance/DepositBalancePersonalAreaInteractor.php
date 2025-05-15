<?php

namespace App\Modules\PersonalArea\Domain\Interactor\Balance;

use App\Modules\Base\DTO\BaseDTO;
use App\Modules\Base\Money\Money;
use Illuminate\Support\Facades\DB;
use App\Modules\Base\Interactor\BaseInteractor;
use App\Modules\PersonalArea\Domain\Models\PersonalArea;
use App\Modules\PersonalArea\App\Data\DTO\DepositBalanceDTO;
use App\Modules\PersonalArea\App\Data\Enums\OperationBalanceEnum;
use App\Modules\PersonalArea\Domain\Actions\BalanceLog\UpdateBalancePersonalAreaAction;

class DepositBalancePersonalAreaInteractor extends BaseInteractor
{


    /**
     * @param DepositBalanceDTO $dto
     *
     * @return bool
     */
    public function execute(BaseDTO $dto) : bool
    {
        return $this->run($dto);
    }


    /**
     * @param DepositBalanceDTO $dto
     *
     * @return bool
     */
    protected function run(BaseDTO $dto) : bool
    {

        /** @var bool */
        $status = DB::transaction(function ($pdo) use($dto) {

            /** @var Money */
            $moneyActual = $dto->personalArea->balance;

            $depositBefore = $this->depositBalance($moneyActual, $dto->moneyDeposit);

            /** @var bool  */
            $personalArea = $this->updateBalancePersonalAreaAction($dto->personalArea, $depositBefore, OperationBalanceEnum::DEPOSIT);

            return $personalArea;
        });

        return $status;
    }

    private function updateBalancePersonalAreaAction(PersonalArea $personalArea, Money $balance, OperationBalanceEnum $operationBalanceEnum) : bool
    {
        return UpdateBalancePersonalAreaAction::make($personalArea, $balance, $operationBalanceEnum);
    }

    private function depositBalance(Money $moneyActual, Money $moneyDeposit) : Money
    {
        return $moneyActual->add($moneyDeposit);
    }


}
