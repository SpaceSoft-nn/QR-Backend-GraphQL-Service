<?php

namespace App\Modules\Transaction\Domain\Interactor\Transaction;

use App\Modules\Base\DTO\BaseDTO;
use Illuminate\Support\Facades\DB;
use App\Modules\Base\Interactor\BaseInteractor;
use App\Modules\Transaction\Domain\Models\QrCode;
use App\Modules\Transaction\Domain\Models\Transaction;
use App\Modules\Transaction\App\Data\DTO\TransactionDTO;
use App\Modules\Transaction\App\Data\ValueObject\QrCodeVO;
use App\Modules\Transaction\Domain\Actions\CreateQrCodeAction;
use App\Modules\Transaction\App\Data\ValueObject\TransactionVO;
use App\Modules\Transaction\Domain\Actions\CreateTransactionAction;

class CreateTransactionInteractor extends BaseInteractor
{
    /**
     *
     * @param TransactionDTO $dto
     *
     * @return Transaction
     */
    public function make(BaseDTO $dto) : Transaction
    {
        return $this->run($dto);
    }

    /**
     * @param TransactionDTO $dto
     *
     * @return Transaction
     */
    protected function run(BaseDTO $dto) : Transaction
    {
        /** @var Transaction */
        $model = DB::transaction(function ($pdo) use ($dto) {


            /** @var TransactionVO */
            $transactionVO = $dto->transaction;

            /** @var Transaction */
            $transaction = $this->createTransaction($transactionVO);

            /**
             * Временно создаём qrCode - тут будет запрос к платежному шлюзу для формирование qr кода
             * @var QrCode
             *
            */
            $qrCode = $this->createQrCode(
                QrCodeVO::make(transaction_id: $transaction->id)
            );

            return $transaction;
        });

        return $model;
    }

    private function createQrCode(QrCodeVO $vo) : QrCode
    {
        return CreateQrCodeAction::make($vo);
    }

    private function createTransaction(TransactionVO $vo) : Transaction
    {
        return CreateTransactionAction::make($vo);
    }



}
