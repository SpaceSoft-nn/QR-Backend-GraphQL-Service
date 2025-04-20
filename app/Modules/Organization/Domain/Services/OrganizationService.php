<?php

namespace App\Modules\Organization\Domain\Services;

use App\Modules\Base\Interface\Service\IService;
use App\Modules\Organization\App\Data\DTO\CreateOrganizationDTO;
use App\Modules\Organization\Domain\Interactor\Organization\CreateOrganizationInteractor;
use App\Modules\Organization\Domain\Models\Organization;

final class OrganizationService implements IService
{

    public function __construct(
        private CreateOrganizationInteractor $createOrganizationInteractor,
    ) { }


    public function createOrganization(CreateOrganizationDTO $dto) : Organization
    {
        return $this->createOrganizationInteractor->execute($dto);
    }
}
