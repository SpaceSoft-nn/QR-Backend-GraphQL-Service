<?php

namespace App\Modules\Workspace\Domain\Interactor;

use App\Modules\Base\DTO\BaseDTO;
use Illuminate\Support\Facades\DB;
use App\Modules\User\Domain\Models\User;
use App\Modules\Base\Interactor\BaseInteractor;
use App\Modules\Pivot\Domain\Models\UserWorkspace;
use App\Modules\Workspace\Domain\Models\Workspace;
use App\Modules\Base\Error\GraphQLBusinessException;
use App\Modules\Workspace\App\Data\DTO\DeleteUserWorkspaceDTO;
use App\Modules\Workspace\App\Data\DTO\SetWorkUserWorkspaceDTO;

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
        $this->userHasWorskpace($dto->workspace, $dto->user);
        $this->userDontUserOwner($dto->userOwner, $dto->user);
    }

    /**
     * Проверяем относистя ли пользователь к данному workspace
     * @param DeleteUserWorkspaceDTO $dto
     *
     * @return void
    */
    private function userHasWorskpace(Workspace $workspace, User $user)
    {
        $status = UserWorkspace::query()->where('workspace_id', $workspace->id)->where('user_id', $user->id)->exists();

        if(!$status) { throw new GraphQLBusinessException('Пользователя которого вы пытаетесь удалить из workspace к нему не относится.' , 403); }
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

        if($userOwner->id === $user->id) {
            #TODO Формально manager может себя добавлять? временно сделали
            throw new GraphQLBusinessException('Авторизированный пользователь не может добавлять самого себя в workspace.' , 400);
        }
    }



}
