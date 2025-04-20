<?php

namespace App\Modules\Organization\Presentation\HTTP\Graphql\Response;

use Nuwave\Lighthouse\Execution\ResolveInfo;
use App\Modules\Auth\Domain\Services\AuthService;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Modules\Organization\App\Data\DTO\CreateOrganizationDTO;
use App\Modules\Organization\App\Data\ValueObject\OrganizationVO;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\Organization\Domain\Services\OrganizationService;
use App\Modules\Organization\Domain\Validators\OrganizationValidator;
use App\Modules\User\Domain\Models\User;
use Illuminate\Support\Collection;

class OrganizationResolver
{

    public function __construct(
        private OrganizationValidator $organizationValidator,
        private OrganizationService $organizationService,
        private AuthService $authService,
    ) {}

    public function store(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) : Organization
    {
        //Валидируем
        $date = $this->organizationValidator->validate($args);

        /** @var OrganizationVO */
        $organizationVO = $this->organizationValidator->createOrganizationsVO($date);

        /** @var User */
        $user = $this->authService->getUserJWT();

        /** @var Organization */
        $organization = $this->organizationService->createOrganization(CreateOrganizationDTO::make(
            user: $user,
            organizationVO: $organizationVO,
        ));

        return $organization;
    }

    public function index(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) : array
    {
        /** @var User */
        $user = $this->authService->getUserJWT();

        /** @var Collection */
        $organizations = $user->organizations;

        return $organizations->toArray();
    }



}

