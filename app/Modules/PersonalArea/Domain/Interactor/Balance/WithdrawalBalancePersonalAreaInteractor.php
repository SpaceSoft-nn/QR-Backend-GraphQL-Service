<?php

namespace App\Modules\PersonalArea\Domain\Interactor\Balance;

use App\Modules\Base\DTO\BaseDTO;
use App\Modules\Base\Money\Money;
use Illuminate\Support\Facades\DB;
use App\Modules\Base\Interactor\BaseInteractor;
use App\Modules\Base\Error\GraphQLBusinessException;
use App\Modules\PersonalArea\Domain\Models\PersonalArea;
use App\Modules\PersonalArea\App\Data\DTO\WithdrawalBalanceDTO;
use App\Modules\Drivers\Domain\Exceptions\TochkaBank\QrBusinessException;
use App\Modules\PersonalArea\App\Data\Enums\OperationBalanceEnum;
use App\Modules\PersonalArea\Domain\Actions\BalanceLog\UpdateBalancePersonalAreaAction;

class WithdrawalBalancePersonalAreaInteractor extends BaseInteractor
{


    /**
     * @param WithdrawalBalanceDTO $dto
     *
     * @return bool
     */
    public function execute(BaseDTO $dto) : bool
    {
        return $this->run($dto);
    }


    /**
     * @param WithdrawalBalanceDTO $dto
     *
     * @return bool
     */
    protected function run(BaseDTO $dto) : bool
    {

        /** @var bool */
        $status = DB::transaction(function ($pdo) use($dto) {

            /** @var Money */
            $moneyActual = $dto->personalArea->balance;

            $depositBefore = $this->withdrawalBalance($moneyActual, $dto->moneyDeposit);

            /** @var bool  */
            $status = $this->updateBalancePersonalAreaAction($dto->personalArea, $depositBefore, OperationBalanceEnum::WITHDRAWAL);

            return $status;
        });

        return $status;
    }

    private function updateBalancePersonalAreaAction(PersonalArea $personalArea, Money $balance, OperationBalanceEnum $operationBalanceEnum) : bool
    {
        return UpdateBalancePersonalAreaAction::make($personalArea, $balance, $operationBalanceEnum);
    }

    private function withdrawalBalance(Money $moneyActual, Money $moneyDeposit) : Money
    {
        /** @var Money */
        $money = $moneyActual->sub($moneyDeposit);

        if($money->lt(0))
        {
            throw new GraphQLBusinessException('У вас недостаточно средств на балансе.', 402);
        }

        return $money;
    }


}
