<?php

namespace App\Modules\Pivot\Domain\Actions\UserOrganization;

use App\Modules\User\Domain\Models\User;
use App\Modules\Organization\Domain\Models\Organization;

class LinkUserToOrganization
{
    /**
     * Нам нужно сохранять связь многие ко многим таким способом (что бы laravel связи работали)
     * @param User $user
     * @param Organization $model
     *
     * @return bool
     */
    public static function run(User $user, Organization $model) : bool
    {
        try {

            //Сохраняем связь от user к personal area
            $user->organizations()->syncWithoutDetaching([$model->id => [
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
