<?php

namespace App\Modules\Workspace\Domain\Interactor;

use App\Modules\Base\DTO\BaseDTO;
use App\Modules\Base\Error\GraphQLBusinessException;
use Illuminate\Support\Facades\DB;
use App\Modules\User\Domain\Models\User;
use App\Modules\Base\Interactor\BaseInteractor;
use App\Modules\Pivot\Domain\Models\UserWorkspace;
use App\Modules\Workspace\App\Data\DTO\SetWorkUserWorkspaceDTO;
use App\Modules\Workspace\Domain\Models\Workspace;

class SetWorkUserWorkspace extends BaseInteractor
{

    /**
     * @param SetWorkUserWorkspaceDTO $dto
     *
     * @return User
     */
    public function make(BaseDTO $dto) : User
    {

        //проводим фильтрацию
        $this->filterCheck($dto);

        return $this->run($dto);
    }

    /**
     * @param SetWorkUserWorkspaceDTO $dto
     *
     * @return User
     */
    protected function run(BaseDTO $dto) : User
    {
        /** @var User */
        $user = DB::transaction(function ($pdo) use ($dto) {

            //устанавливаем через промежуточную таблицу для user - которого ставим в работу active_user = true, для остальных false
            UserWorkspace::query()
                ->where('workspace_id', $dto->workspace->id)
                ->update([
                    'active_user' => DB::raw("CASE WHEN user_id = '{$dto->user->id}' THEN true ELSE false END")
                ]);


            return $dto->user;

        });

        return $user;
    }

    private function filterCheck(SetWorkUserWorkspaceDTO $dto)
    {
        $this->userHasWorskpace($dto->workspace, $dto->user);
        $this->userDontUserOwner($dto->userOwner, $dto->user);
    }

    /**
     * Проверяем относистя ли пользователь к данному workspace
     * @param SetWorkUserWorkspaceDTO $dto
     *
     * @return void
    */
    private function userHasWorskpace(Workspace $workspace, User $user)
    {
        $status = UserWorkspace::query()->where('workspace_id', $workspace->id)->where('user_id', $user->id)->exists();

        if(!$status) { throw new GraphQLBusinessException('Пользователь который устанавливается в работу, не относистя к этому workspace.' , 403); }
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
