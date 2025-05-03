<?php

namespace App\Modules\Transaction\App\Repositories;

use App\Modules\Workspace\Domain\Models\Workspace;
use App\Modules\Base\Interface\Repositories\CoreRepository;
use App\Modules\Transaction\Domain\Interface\Repositories\ITransactionRepository;
use App\Modules\Transaction\Domain\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;

final class TransactionRepository extends CoreRepository implements ITransactionRepository
{
    protected function getModelClass()
    {
        return Transaction::class;
    }

    private function query() : \Illuminate\Database\Eloquent\Builder
    {
        return $this->startConditions()->query();
    }

    /**
     * Вернуть все транзакции которые принадлежат workspace
     * @param string $workspace_id
     *
     *  @return Collection|\App\Modules\Transaction\Domain\Models\Transaction[]
     */
    public function transactionsByWorkspace(string $workspace_id) : Collection
    {
        /** @var Collection */
        $transactions = $this->query()->where('workspace_id', $workspace_id)->get();

        return $transactions;
    }

}
