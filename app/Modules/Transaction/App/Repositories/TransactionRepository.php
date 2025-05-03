<?php

namespace App\Modules\Transaction\App\Repositories;

use App\Modules\User\Domain\Models\User;
use Illuminate\Database\Eloquent\Collection;
use App\Modules\Workspace\Domain\Models\Workspace;
use App\Modules\Transaction\Domain\Models\Transaction;
use App\Modules\Base\Interface\Repositories\CoreRepository;
use App\Modules\Transaction\Domain\Interface\Repositories\ITransactionRepository;
use App\Modules\User\App\Data\Enums\UserRoleEnum;

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
    public function transactionsByWorkspace(string $workspace_id, ?User $user = null) : Collection
    {
        //если user кассир - возвращаем ему только его транзакции
        if(isset($user) && UserRoleEnum::isCassier($user->role))
        {
            return $this->query()->where('user_id', $workspace_id)->get();
        }

        /** @var Collection */
        $transactions = $this->query()->where('workspace_id', $workspace_id)->get();

        return $transactions;
    }

}
