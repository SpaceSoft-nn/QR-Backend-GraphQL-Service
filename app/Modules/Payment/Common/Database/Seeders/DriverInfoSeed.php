<?php

namespace App\Modules\Payment\Common\Database\Seeders;

use App\Modules\Payment\Domain\Models\DriverInfo;
use App\Modules\User\Domain\Models\User;
use Illuminate\Database\Seeder;

class DriverInfoSeed extends Seeder
{

    public function run(): void
    {
        $this->createDriverInfo();
    }

    private function createDriverInfo()
    {
        DriverInfo::factory()->state(function (array $attributes) {

            $user = User::first();

            return ['user_organization_id' => $user->userOrganization->first()->id];

        })->create();
    }



}
