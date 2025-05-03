<?php

namespace App\Modules\Workspace\App\Policies;

use Illuminate\Auth\Access\Response;
use App\Modules\User\Domain\Models\User;
use App\Modules\User\App\Data\Enums\UserRoleEnum;
use App\Modules\Pivot\Domain\Models\UserWorkspace;
use App\Modules\Workspace\Domain\Models\Workspace;
use App\Modules\Base\Error\GraphQLBusinessException;

class WorkspacePolicy
{

    public function viewAny(User $user): bool
    {
        return true;
    }


    public function view(User $user, Workspace $workspace): bool
    {
        return true;
    }

    /**
     * Проверяем принадлежит ли данный пользователь к workspace
     * @param Workspace $workspace
     * @param User $user
     *
    */
    public function userHasWorkspace(User $user, Workspace $workspace) : Response
    {

        $status = UserWorkspace::query()->where('workspace_id', $workspace->id)->where('user_id', $user->id)->exists();

        return ($status)
        ? Response::allow()
        : throw new GraphQLBusinessException('Пользователя которого вы пытаетесь удалить из ARM к нему не относится.' , 403);

    }



    /**
     * Проверяем имеет ли данный пользователь права на удаление
     * @param Workspace $workspace
     * @param User $user
     *
     */
    public function userHasWorkspaceDelete(User $user, Workspace $workspace) : Response
    {
        $status = UserWorkspace::query()->where('workspace_id', $workspace->id)->where('user_id', $user->id)->exists();

        return ($status)
        ? Response::allow()
        : throw new GraphQLBusinessException('Пользователя которого вы пытаетесь удалить из ARM к нему не относится.' , 403);

    }

    /**
     * @param User $userOwner
     * @param User $user
     *
     */
    public function userDontUserOwner(User $userOwner, User $user) : Response
    {

        return ($userOwner->id === $user->id)
        ? Response::allow()
        : throw new GraphQLBusinessException('Авторизированный пользователь не может добавлять самого себя в workspace.' , 400);

    }




    public function create(User $user): Response
    {
        return UserRoleEnum::isAdmin($user->role) || UserRoleEnum::isManager($user->role)
        ? Response::allow()
        : throw new GraphQLBusinessException('У пользователя нету прав для создание АРМ.', 403);
    }


    public function update(User $user, Workspace $workspace): Response
    {
        return UserRoleEnum::isAdmin($user->role) || UserRoleEnum::isManager($user->role)
        ? Response::allow()
        : throw new GraphQLBusinessException('У пользователя нету прав для обновления АРМ.', 403);
    }


    public function delete(User $user, Workspace $workspace): Response
    {
        return UserRoleEnum::isAdmin($user->role) || UserRoleEnum::isManager($user->role)
        ? Response::allow()
        : throw new GraphQLBusinessException('У пользователя нету прав для удаления АРМ.', 403);
    }


    // public function restore(User $user, Workspace $workspace): bool
    // {
    //     return false;
    // }


    // public function forceDelete(User $user, Workspace $workspace): bool
    // {
    //     return false;
    // }
}
