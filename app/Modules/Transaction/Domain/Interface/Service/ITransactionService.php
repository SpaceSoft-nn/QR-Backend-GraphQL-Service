<?php

namespace App\Modules\Transaction\Domain\Interface\Service;

use App\Modules\Transaction\App\Data\DTO\TransactionDTO;
use App\Modules\Transaction\Domain\Models\Transaction;

interface ITransactionService
{
    public function createTransaction(TransactionDTO $dto) : Transaction;
}
