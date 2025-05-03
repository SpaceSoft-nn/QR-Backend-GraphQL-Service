<?php

namespace App\Modules\Transaction\Domain\Services;

use App\Modules\Transaction\Domain\Models\Transaction;
use App\Modules\Transaction\App\Data\DTO\TransactionDTO;
use App\Modules\Transaction\Domain\Interface\Service\ITransactionService;
use App\Modules\Transaction\Domain\Interactor\Transaction\CreateTransactionInteractor;

    final class TransactionService implements ITransactionService
    {

        private CreateTransactionInteractor $createTransactionInteractor;

        public function __construct(
            CreateTransactionInteractor $createTransactionInteractor,
        ) {
            $this->createTransactionInteractor = $createTransactionInteractor;
        }


        /**
         * @param TransactionDTO $dto
         *
         * @return Transaction
         */
        public function createTransaction(TransactionDTO $dto) : Transaction
        {
            return $this->createTransactionInteractor->execute($dto);
        }


    }
