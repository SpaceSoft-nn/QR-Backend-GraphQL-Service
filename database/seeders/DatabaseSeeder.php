<?php

namespace Database\Seeders;

use App\Modules\Notification\Domain\Models\EmailList;
use App\Modules\PersonalArea\Domain\Models\PersonalArea;
use App\Modules\User\App\Data\Enums\UserRoleEnum;
use App\Modules\User\Domain\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {

        $email = EmailList::factory()->create([
            'value' => 'test@mail.ru',
            'status' => true,
        ]);



        $user = User::factory()
            ->afterCreating(function ($user) {

                //создаём личный кабинет
                {
                    $personalArea = PersonalArea::factory()->create([
                        'owner_id' => $user->id,
                    ]);
                    $user->personalAreas()->attach($personalArea->id);
                }

                //создаём организацию
                {

                }


            })
            ->for($email, 'emailList')
        ->create([
            'password' => 'password',
        ]);

    }
}
