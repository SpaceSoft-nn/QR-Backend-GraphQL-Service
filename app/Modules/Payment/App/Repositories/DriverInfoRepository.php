<?php

namespace App\Modules\Payment\App\Repositories;

use App\Modules\User\Domain\Models\User;
use App\Modules\Base\Interface\Repositories\CoreRepository;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\Payment\Domain\Interface\Service\Repository\IDriverInfoRepository;
use App\Modules\Payment\Domain\Models\DriverInfo;

final class DriverInfoRepository extends CoreRepository implements IDriverInfoRepository
{
    protected function getModelClass()
    {
        return User::class;
    }

    private function query() : \Illuminate\Database\Eloquent\Builder
    {
        return $this->startConditions()->query();
    }

    // private function organization(DriverInfo $driver) : Organization
    // {
    //     return $driver->user_organization_id
    // }
}
