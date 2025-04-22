<?php

namespace App\Modules\Workspace\Domain\Interactor;

use App\Modules\Base\DTO\BaseDTO;
use App\Modules\Base\Error\GraphQLBusinessException;
use Illuminate\Support\Facades\DB;
use App\Modules\User\Domain\Models\User;
use App\Modules\Base\Interactor\BaseInteractor;
use App\Modules\Workspace\Domain\Models\Workspace;
use App\Modules\Workspace\App\Data\DTO\AddUserWorkspaceDTO;
use App\Modules\Pivot\Domain\Actions\UserWorkspace\LinkUserToWorkspace;
use App\Modules\User\App\Data\Enums\UserRoleEnum;

class AddUserWorkspaceInteractor extends BaseInteractor
{

    /**
     * @param AddUserWorkspaceDTO $dto
     *
     * @return User
     */
    public function execute(BaseDTO $dto) : User
    {

        //проводим фильтрацию
        $this->filterCheck($dto);

        return $this->run($dto);
    }

    /**
     * @param AddUserWorkspaceDTO $dto
     *
     * @return User
     */
    protected function run(BaseDTO $dto) : User
    {
        /** @var User */
        $user = DB::transaction(function ($pdo) use ($dto) {

            /** @var User */
            $user = $dto->user;

            /** @var Workspace */
            $workspace = $dto->workspace;

            $status = LinkUserToWorkspace::run($user, $workspace, false);

            return $user;

        });

        return $user;
    }

    private function filterCheck(AddUserWorkspaceDTO $dto)
    {

        $this->hasUserRole($dto->userOwner);
        $this->existsUserOwner($dto->userOwner, $dto->user);
        $this->existsUserWorkspace($dto->user, $dto->workspace);
        $this->userDontUserOwner($dto->userOwner, $dto->user);
    }

    /**
     * проверяем что у пользователя достаточная роль
     * @param User $userOwner
     *
     * @throws \GraphQLBusinessException Если у пользователя недостаточная роль.
     *
     * @return void
     * throw
    */
    private function hasUserRole(User $userOwner) : bool
    {
        if(UserRoleEnum::isManager($userOwner->role) || UserRoleEnum::isAdmin($userOwner->role)) {
            return true;
        }

        throw new GraphQLBusinessException('У вас недостаточно прав, для выполнения этого действия' , 403);
    }

    /**
     * Проверяем что пользователь принадлежит к авторизированному пользователю.
     * @param User $userOwner
     *
     * @return void
     * @throws \GraphQLBusinessException Если пользователь не принадлежит.
     * throw
    */
    private function existsUserOwner(User $userOwner, User $user) : void
    {
        //проверяем что пользователь которого мы добавляем, относится по связям к авторизированному
        $ownerPersonalAreaIds = $userOwner->personalAreas()->pluck('personal_area_id');

        $hasCommon = $user->personalAreas()->whereIn('personal_area_id', $ownerPersonalAreaIds)
            ->exists();

        if(!$hasCommon) { throw new GraphQLBusinessException('Вы не имеете прав для добавления пользователя в этот workspace.' , 403); }
    }

    /**
     * Проверяем добавлен ли пользователь
     * @param User $user
     * @param Workspace $workspace
     * @throws \GraphQLBusinessException Если пользователь уже добавлен в workspace.
     * @return void
     */
    private function existsUserWorkspace(User $user, Workspace $workspace)
    {
        $hasCommon = $user->workspaces()->where('workspace_id', $workspace->id)
            ->exists();

        if($hasCommon) { throw new GraphQLBusinessException('Пользователь уже был добавлен в данный workspace.' , 400); }
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
