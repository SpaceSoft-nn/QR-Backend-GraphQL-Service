<?php

namespace App\Modules\Pivot\Domain\Actions\PersonalAreaUser;

use App\Modules\PersonalArea\Domain\Models\PersonalArea;
use App\Modules\User\Domain\Models\User;

class LinkUserToPersonalAreaAction
{
    /**
     * Нам нужно сохранять связь многие ко многим таким способом (что бы laravel связи работали)
     * @param User $user
     * @param PersonalArea $personalArea
     *
     * @return bool
     */
    public static function run(User $user, PersonalArea $personalArea) : bool
    {
        try {

            //Сохраняем связь от user к personal area
            $user->personalAreas()->syncWithoutDetaching([$personalArea->id => [
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);

            return true;

        } catch (\Throwable $th) {

            return false;

        }

    }
}
