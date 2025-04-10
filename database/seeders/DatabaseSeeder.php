<?php

namespace Database\Seeders;

use App\Modules\Notification\Domain\Models\EmailList;
use App\Modules\User\App\Data\Enums\UserRoleEnum;
use App\Modules\User\Domain\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        User::factory()->for(
            EmailList::factory()->create([
                'value' => 'test@mail.ru',
                'status' => true,
            ]) , 'email'
        )->create([
            'password' => 'password'
        ]);
    }
}
