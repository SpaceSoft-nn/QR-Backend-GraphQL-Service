<?php

namespace App\Modules\Payment\App\Repositories;

use App\Modules\Payment\Domain\Models\DriverInfo;
use App\Modules\Base\Error\GraphQLBusinessException;
use App\Modules\Pivot\Domain\Models\UserOrganization;
use App\Modules\Base\Interface\Repositories\CoreRepository;
use App\Modules\Payment\Domain\Interface\Service\Repository\IDriverInfoRepository;

final class DriverInfoRepository extends CoreRepository implements IDriverInfoRepository
{
    protected function getModelClass()
    {
        return DriverInfo::class;
    }

    private function query() : \Illuminate\Database\Eloquent\Builder
    {
        return $this->startConditions()->query();
    }

    public function driverInfoByOrganizationId(string $organization_id, string $payment_method_id, string $user_id) : ?DriverInfo
    {
        /** @var UserOrganization */
        $user_organization = UserOrganization::where('organization_id', $organization_id)->where('user_id', $user_id)->first();

        if(!$user_organization) {
            throw new GraphQLBusinessException('Этот пользователь не относится к этой организации' , 403);
        };

        return $this->query()->where('payment_method_id', $payment_method_id)->where('user_organization_id', $user_organization->id)->first();
    }
}
