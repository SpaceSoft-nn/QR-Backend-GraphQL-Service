<?php

namespace Database\Seeders;

use App\Modules\Notification\Domain\Models\EmailList;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\PersonalArea\Domain\Models\PersonalArea;
use App\Modules\Pivot\Domain\Actions\PersonalAreaUser\LinkUserToPersonalAreaAction;
use App\Modules\Pivot\Domain\Actions\UserOrganization\LinkUserToOrganization;
use App\Modules\Pivot\Domain\Actions\UserWorkspace\LinkUserToWorkspace;
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


                { //Привязываем дополнительно user

                    $email_new = EmailList::factory()->create([
                        'value' => 'test2@mail.ru',
                        'status' => true,
                    ]);

                    $user_new = User::factory()->for($email_new, 'emailList')->create([

                        'role' => UserRoleEnum::cassier
                    ]);

                    $personalArea = $user->personalAreas()->first();
                    $status = LinkUserToPersonalAreaAction::run($user_new, $personalArea);

                }

                //создаём организацию
                {
                    $organization = Organization::factory()->create([
                        'owner_id' => $user->id,
                    ]);
                    $user->organizations()->attach($organization->id);

                    //привязываем дополнительно нового user
                    $org = $user->organizations()->first();
                    $status = LinkUserToOrganization::run($user_new, $org);
                }


            })
            ->for($email, 'emailList')
        ->create([
            'password' => 'password',
        ]);

    }
}
