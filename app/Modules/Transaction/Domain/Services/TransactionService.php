<?php

namespace App\Modules\Transaction\Domain\Services;

use App\Modules\Transaction\Domain\Models\Transaction;
use App\Modules\Transaction\App\Data\DTO\TransactionDTO;
use App\Modules\Workspace\Domain\Interface\IWorkspaceService;
use App\Modules\Transaction\Domain\Interactor\Transaction\CreateTransactionInteractor;

final class TransactionService implements IWorkspaceService
{

    public function __construct(
        private CreateTransactionInteractor $createTransactionInteractor,
    ) { }


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
