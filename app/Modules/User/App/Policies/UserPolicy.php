<?php

namespace App\Modules\User\App\Policies;

use Illuminate\Auth\Access\Response;
use App\Modules\User\Domain\Models\User;

use App\Modules\User\App\Data\Enums\UserRoleEnum;
use App\Modules\Base\Error\GraphQLBusinessException;

class UserPolicy
{

    /**
     * проверяем что user, не является самим собой
     * @param User $userOwner
     * @param User $user
     *
     */
    public function userDontUserOwner(User $userOwner, User $user) : Response
    {

        return ($userOwner->id === $user->id)
            ? throw new GraphQLBusinessException('Авторизированный пользователь не может добавлять самого себя в ARM.' , 400)
            : Response::allow();

    }

     /**
     * Провречем что user, который передали, относится к User - авторизированному
     * @param User $userOwner
     * @param User $user
     *
     */
    public function hasUserByUserOwner(User $userOwner, User $user) : Response
    {

        #TODO изучить запрос?
        $status = $userOwner->personalAreas()
            ->whereHas('users', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            })
            ->exists();



        return ($status)
            ? Response::allow()
            : throw new GraphQLBusinessException('Авторизированный пользователь не относится к переданному User.' , 403);

    }


    public function UserAdminOrManager(User $userOwner, User $user) : Response
    {
        $status = (bool) ( UserRoleEnum::isAdmin($userOwner->role) || UserRoleEnum::isManager($userOwner->role) );

        return ($status)
            ? Response::allow()
            : throw new GraphQLBusinessException('У авторизированного пользователя, нету прав для совершения этого действия' , 403);
    }

    /**
     * Проверяем что user - является кассиром
     * @param User $user
     *
     * @return bool
     */
    public function userIsCassier(User $user) : bool
    {
        $status = UserRoleEnum::isCassier($user->role);

        return $status;
    }

}
