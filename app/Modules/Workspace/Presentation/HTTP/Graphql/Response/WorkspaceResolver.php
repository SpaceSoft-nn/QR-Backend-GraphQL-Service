<?php

namespace App\Modules\Workspace\Presentation\HTTP\Graphql\Response;

use App\Modules\User\Domain\Models\User;
use Nuwave\Lighthouse\Execution\ResolveInfo;
use App\Modules\Auth\Domain\Services\AuthService;
use App\Modules\Workspace\Domain\Models\Workspace;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Modules\Workspace\App\Data\DTO\CreateWorkspaceDTO;
use App\Modules\Workspace\App\Data\ValueObject\WorkspaceVO;
use App\Modules\Workspace\Domain\Services\WorkspaceService;

class WorkspaceResolver
{

    public function __construct(
        private WorkspaceService $workspaceService,
        private AuthService $authService,
    ) {}


    /**
     * Создание user (manager/cassier)
     *
     * @return array
     */
    public function store(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) : Workspace
    {

        /**
         * Получаем User по токену
         * @var User
         *
        */
        $user = $this->authService->getUserAuth();

        /** @var CreateWorkspaceDTO */
        $createWorkspaceDTO = CreateWorkspaceDTO::make(
            user: $user,
            workspaceVO: WorkspaceVO::fromArrayToObject($args, $user),
        );

        /** @var Workspace */
        $workspace = $this->workspaceService->createWorkspace($createWorkspaceDTO);

        return $workspace;
    }

}

