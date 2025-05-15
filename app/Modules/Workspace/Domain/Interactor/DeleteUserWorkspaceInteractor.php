<?php

namespace App\Modules\Workspace\Domain\Interactor;

use App\Modules\Base\DTO\BaseDTO;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Modules\User\Domain\Models\User;
use App\Modules\Base\Interactor\BaseInteractor;
use App\Modules\Workspace\Domain\Models\Workspace;
use App\Modules\Base\Error\GraphQLBusinessException;
use App\Modules\Workspace\App\Data\DTO\DeleteUserWorkspaceDTO;

class DeleteUserWorkspaceInteractor extends BaseInteractor
{

    /**
     * @param DeleteUserWorkspaceDTO $dto
     *
     * @return array
     */
    public function execute(BaseDTO $dto) : array
    {

        //проводим фильтрацию
        $this->filterCheck($dto);

        return $this->run($dto);
    }

    /**
     * @param DeleteUserWorkspaceDTO $dto
     *
     * @return array
     */
    protected function run(BaseDTO $dto) : array
    {

        /** @var array */
        $arr = DB::transaction(function ($pdo) use ($dto) {

            /** @var Workspace */
            $workspace = $dto->workspace;

            $status = $workspace->users()->detach($dto->user->id);

            return [
                "user_id" => $dto->user->id,
                "status" => $status,
            ];

        });

        return $arr;
    }

    private function filterCheck(DeleteUserWorkspaceDTO $dto)
    {
        $this->userHasWorkspaceDelete($dto->workspace, $dto->user);
        $this->userDontUserOwner($dto->userOwner, $dto->user);
    }

    /**
     * Проверяем относится ли пользователь к данному workspace
     * @param DeleteUserWorkspaceDTO $dto
     *
     * @return void
    */
    private function userHasWorkspaceDelete(Workspace $workspace, User $user)
    {
        Gate::forUser($user)->authorize('userHasWorkspaceDelete', [$workspace]);
    }


    /**
     * Проверяем что авторизированный пользователь не добавляет самого себя
     * @param User $user
     * @param Workspace $workspace
     * @throws \GraphQLBusinessException Авторизированный пользователь не может добавлять самого себя в workspace.
     * @return void
    */
    private function userDontUserOwner(User $userOwner, User $user)
    {

        Gate::forUser($userOwner)->authorize('userDontUserOwner', [$user]);
    }



}
