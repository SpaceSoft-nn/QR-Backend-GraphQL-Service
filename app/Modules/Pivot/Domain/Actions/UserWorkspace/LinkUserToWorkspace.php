<?php

namespace App\Modules\Pivot\Domain\Actions\UserWorkspace;

use App\Modules\User\Domain\Models\User;
use App\Modules\Workspace\Domain\Models\Workspace;

class LinkUserToWorkspace
{
    /**
     * Нам нужно сохранять связь многие ко многим таким способом (что бы laravel связи работали)
     * @param User $user
     * @param Workspace $model
     * @param bool $is_owner является ли пользователь создателям workspace
     *
     * @return bool
     */
    public static function run(
        User $user,
        Workspace $model,
        ?bool $is_owner = false,
    ) : bool {
        try {

            //Сохраняем связь от user к personal area
            $user->workspaces()->syncWithoutDetaching([$model->id => [
                    'created_at' => now(),
                    'updated_at' => now(),
                    'is_owner' => $is_owner,
                ]
            ]);

            return true;

        } catch (\Throwable $th) {

            return false;

        }

    }
}
