<?php

namespace App\Modules\Organization\Domain\Interactor\Organization;

use App\Modules\Base\DTO\BaseDTO;
use Illuminate\Support\Facades\DB;
use App\Modules\Base\Interactor\BaseInteractor;
use App\Modules\Base\Interface\Interactor\IInteractor;
use App\Modules\Organization\App\Data\DTO\CreateOrganizationDTO;
use App\Modules\Organization\App\Data\ValueObject\OrganizationVO;
use App\Modules\Organization\Domain\Actions\Organization\CreateOrganizationAction;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\Pivot\Domain\Actions\UserOrganization\LinkUserToOrganization;
use App\Modules\User\Domain\Models\User;

class CreateOrganizationInteractor extends BaseInteractor
{

    public function __construct(

    ) { }

    /**
     * @param CreateOrganizationDTO
     *
     * @return Organization
    */
    public function make(BaseDTO $dto) : Organization
    {
        return $this->run($dto);
    }

    /**
     * @param CreateOrganizationDTO $dto
     *
     * @return Organization
     */
    protected function run(BaseDTO $dto) : Organization
    {
        /** @var Organization */
        $model = DB::transaction(function ($pdo) use ($dto) {

            /** @var User */
            $user = $dto->user;

            /** @var OrganizationVO */
            $vo = $dto->organizationVO->addOwner($user->id);

            /** @var Organization */
            $organization = $this->createOrganization($vo);

            //устанавливаем связь
            $status = LinkUserToOrganization::run($user, $organization);

            return $organization;
        });

        return $model;
    }

    private function createOrganization(OrganizationVO $vo) : Organization
    {
        return CreateOrganizationAction::make($vo);
    }


}
