<?php

namespace App\Modules\Transaction\App\Policies;

use Illuminate\Auth\Access\Response;
use App\Modules\User\Domain\Models\User;

use App\Modules\Base\Error\GraphQLBusinessException;
use App\Modules\Pivot\Domain\Models\UserWorkspace;

class TransactionPolicy
{

    /**
     * Проверяем, является ли user активным рабочим в ARM - если да, разрешаем ему создавать транзакции.
     * @param User $user
     * @param string $workspace_id
     * @param ?string $message
     *
     * @return Response
     */
    public function userHasCreateTransaction(User $user, string $workspace_id, ?string $message = null) : Response
    {

        $status = UserWorkspace::query()
            ->where('workspace_id', $workspace_id)
            ->where('user_id', $user->id)
            ->where('active_user', true)
            ->first();

        $message ?? 'Пользователь должен быть выбран как рабочий в АРМ, для выполнения этого действия.';

        return ($status)
            ? Response::allow()
            : throw new GraphQLBusinessException($message , 403);

    }

}
