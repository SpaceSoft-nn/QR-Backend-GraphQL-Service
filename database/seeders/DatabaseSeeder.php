<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\User\Domain\Models\User;
use App\Modules\User\App\Data\Enums\UserRoleEnum;
use App\Modules\Workspace\Domain\Models\Workspace;
use App\Modules\Payment\Domain\Models\PaymentMethod;
use App\Modules\Notification\Domain\Models\EmailList;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\PersonalArea\Domain\Models\PersonalArea;
use App\Modules\Subscription\Domain\Models\SubscriptionPlan;
use App\Modules\Pivot\Domain\Actions\UserWorkspace\LinkUserToWorkspace;
use App\Modules\Pivot\Domain\Actions\UserOrganization\LinkUserToOrganization;
use App\Modules\Pivot\Domain\Actions\PersonalAreaUser\LinkUserToPersonalAreaAction;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {

        $this->call([
            \App\Modules\Payment\Common\Database\Seeders\PaymentSeed::class,
        ]);


        $email = EmailList::factory()->create([
            'value' => 'qjq3@mail.ru',
            'status' => true,
        ]);

        $user = User::factory()
            ->afterCreating(function ($user) {

                //создаём личный кабинет
                {
                    $personalArea = PersonalArea::factory()
                        ->afterCreating(function ($model) {
                            SubscriptionPlan::factory()->create([
                                "personal_area_id" => $model->id,
                            ]);
                        })
                        ->create([
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

                        'role' => UserRoleEnum::CASSIER
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

                { // создаём рабочие места

                    $workspaces = Workspace::factory()
                        ->count(30)
                        ->withUserOrganization($user)
                        ->withPersonalArea($personalArea)
                        ->create([
                            "payment_method_id" => PaymentMethod::inRandomOrder()->first()->id,
                        ]);

                    foreach ($workspaces as $workspace) {
                        LinkUserToWorkspace::run($user, $workspace, true);
                    }
                }

            })
            ->for($email, 'emailList')
        ->create([
            'password' => 'password',
        ]);


        $this->call([
            \App\Modules\Payment\Common\Database\Seeders\DriverInfoSeed::class,
            \App\Modules\Subscription\Common\Database\Seeders\TariffSeed::class,
        ]);

    }
}
