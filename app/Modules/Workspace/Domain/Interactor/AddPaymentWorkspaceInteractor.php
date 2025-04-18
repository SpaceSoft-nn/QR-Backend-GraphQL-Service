<?php

namespace App\Modules\Workspace\Domain\Interactor;

use App\Modules\Base\DTO\BaseDTO;
use Illuminate\Support\Facades\DB;
use App\Modules\User\Domain\Models\User;
use App\Modules\Base\Interactor\BaseInteractor;
use App\Modules\Workspace\Domain\Models\Workspace;
use App\Modules\Base\Error\GraphQLBusinessException;
use App\Modules\Payment\Domain\Models\PaymentMethod;
use App\Modules\Workspace\App\Data\DTO\AddPaymentWorkspaceDTO;

final class AddPaymentWorkspaceInteractor extends BaseInteractor
{

    /**
     * @param AddPaymentWorkspaceDTO $dto
     *
     * @return Workspace
     */
    public function make(BaseDTO $dto) : Workspace
    {
        $this->checkFilter($dto);

        return $this->run($dto);
    }

    /**
     * @param AddPaymentWorkspaceDTO $dto
     *
     * @return Workspace
     */
    protected function run(BaseDTO $dto) : Workspace
    {
        /** @var Workspace */
        $model = DB::transaction(function ($pdo) use ($dto) {

            /** @var PaymentMethod */
            $paymentMethod = $this->findPaymentMethodId($dto->payment_method_id);

            /** @var Workspace */
            $workspace = $this->findWorkspaceId($dto->worksapce_id);

            $workspace->payment_method_id = $paymentMethod->id;

            $workspace->save();

            return $workspace;

        });

        return $model;
    }

    private function findPaymentMethodId(string $payment_method_id) : PaymentMethod
    {
        $paymentMethod = PaymentMethod::find($payment_method_id);

        if(is_null($paymentMethod)){
            throw new GraphQLBusinessException('Записи Payment Method по id не существует.', 404);
        }

        return $paymentMethod;
    }

    private function findWorkspaceId(string $worksapce_id) : Workspace
    {
        $workspace = Workspace::find($worksapce_id);

        if(is_null($workspace)){
            throw new GraphQLBusinessException('Записи Workspace по id не существует.', 404);
        }

        return $workspace;
    }

    private function checkFilter(AddPaymentWorkspaceDTO $dto)
    {
        /** @var User */
        $user = $dto->user;

        $status = $user->workspaces()->wherePivot('workspace_id', $dto->worksapce_id)->first();

        if(is_null($status)) {
            throw new GraphQLBusinessException('Данный пользователь не относится к этому workspace.', 403);
        }

        return true;
    }

}
