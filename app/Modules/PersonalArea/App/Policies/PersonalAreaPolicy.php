<?php

namespace App\Modules\PersonalArea\App\Policies;

use Illuminate\Auth\Access\Response;
use App\Modules\User\Domain\Models\User;

use App\Modules\Base\Error\GraphQLBusinessException;
use App\Modules\Pivot\Domain\Models\UserPersonalArea;
use App\Modules\PersonalArea\Domain\Models\PersonalArea;

class PersonalAreaPolicy
{

    /**
     * Принадлежит ли пользователь к PersonalArea
     * @param User $user
     * @param PersonalArea $personalArea
     *
     * @return Response
     */
    public function userHasPersonalArea(User $user, PersonalArea $personalArea) : Response
    {

        $status = UserPersonalArea::where('user_id', $user->id)->where('personal_area_id', $personalArea->id)->exists();

        return ($status)
            ? Response::allow()
                : throw new GraphQLBusinessException('Данный пользователь не относится к этому личному кабинету.' , 403);

    }

}
