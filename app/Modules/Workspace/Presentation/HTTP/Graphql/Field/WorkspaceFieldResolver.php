<?php

namespace App\Modules\Workspace\Presentation\HTTP\Graphql\Field;

use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\User\Domain\Models\User;
use App\Modules\Workspace\App\Repositories\WorkspaceRepository;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class WorkspaceFieldResolver
{

    protected WorkspaceRepository $workspaceRepository;

    // Внедряем репозиторий через конструктор
    public function __construct(WorkspaceRepository $workspaceRepository)
    {
        $this->workspaceRepository = $workspaceRepository;
    }

    public function organization(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) : Organization
    {
        return $this->workspaceRepository->organization($root);
    }


    public function user_owner(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) : User
    {
        return $this->workspaceRepository->userOwner($root);
    }

    public function user_worker(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) : ?User
    {
        return $this->workspaceRepository->userActive($root);
    }


}
