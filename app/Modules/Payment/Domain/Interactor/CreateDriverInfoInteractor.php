<?php

namespace App\Modules\Payment\Domain\Interactor;

use App\Modules\Base\DTO\BaseDTO;
use Illuminate\Support\Facades\DB;
use App\Modules\User\Domain\Models\User;
use App\Modules\Base\Interactor\BaseInteractor;
use App\Modules\Payment\Domain\Models\DriverInfo;
use App\Modules\Base\Error\GraphQLBusinessException;
use App\Modules\Pivot\Domain\Models\UserOrganization;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\Payment\App\Data\DTO\CreateDriverInfoDTO;
use App\Modules\Payment\App\Data\ValueObject\DriverInfoVO;
use App\Modules\Payment\Domain\Actions\UpdateOrCreateDriverInfoAction;

class CreateDriverInfoInteractor extends BaseInteractor
{
    /**
     *
     * @param CreateDriverInfoDTO $dto
     *
     * @return DriverInfo
     */
    public function execute(BaseDTO $dto) : DriverInfo
    {
        return $this->run($dto);
    }

    /**
     * @param CreateDriverInfoDTO $dto
     *
     * @return DriverInfo
     */
    protected function run(BaseDTO $dto) : DriverInfo
    {
        /** @var DriverInfo */
        $model = DB::transaction(function ($pdo) use ($dto) {

            /** @var UserOrganization */
            $userOrganization = $this->findUserOrganization($dto->organization_id, $dto->user);

            /** @var DriverInfo */
            $driverInfo = $this->updateOrCreateDriverInfoAction(DriverInfoVO::make(
                key: $dto->key,
                value: $dto->value,
                payment_method_id: $dto->payment_method_id,
                user_organization_id: $userOrganization->id,
            ));

            return $driverInfo;
        });

        return $model;
    }

    private function updateOrCreateDriverInfoAction(DriverInfoVO $vo) : DriverInfo
    {
        return UpdateOrCreateDriverInfoAction::make($vo);
    }

    private function findUserOrganization(string $organization_id, User $user) : UserOrganization
    {
        /** @var Organization */
        $organization = Organization::find($organization_id);

        $userOrganization = UserOrganization::where('user_id', $user->id)->where('organization_id', $organization->id)->first();

        if(!$userOrganization) {
            throw new GraphQLBusinessException('Организация и user не связаны.', 403);
        }

        return $userOrganization;
    }


}
