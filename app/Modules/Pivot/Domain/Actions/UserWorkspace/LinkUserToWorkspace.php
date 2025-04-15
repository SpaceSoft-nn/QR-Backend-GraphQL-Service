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
     *
     * @return bool
     */
    public static function run(User $user, Workspace $model) : bool
    {
        try {

            //Сохраняем связь от user к personal area
            $user->workspaces()->syncWithoutDetaching([$model->id => [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);

            return true;

        } catch (\Throwable $th) {

            return false;

        }

    }
}
