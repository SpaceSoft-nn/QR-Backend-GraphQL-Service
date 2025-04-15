<?php

namespace App\Modules\Workspace\Presentation\HTTP\Graphql\Response;

use Illuminate\Support\Collection;
use App\Modules\User\Domain\Models\User;
use Nuwave\Lighthouse\Execution\ResolveInfo;
use App\Modules\Auth\Domain\Services\AuthService;
use App\Modules\Workspace\Domain\Models\Workspace;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Modules\Workspace\App\Data\DTO\CreateWorkspaceDTO;
use App\Modules\Workspace\App\Data\DTO\AddUserWorkspaceDTO;
use App\Modules\Workspace\App\Data\DTO\DeleteUserWorkspaceDTO;
use App\Modules\Workspace\App\Data\DTO\SetWorkUserWorkspaceDTO;
use App\Modules\Workspace\App\Data\ValueObject\WorkspaceVO;
use App\Modules\Workspace\Domain\Services\WorkspaceService;

class WorkspaceResolver
{

    public function __construct(
        private WorkspaceService $workspaceService,
        private AuthService $authService,
    ) {}


    /**
     * Создание Workspace
     * @return Workspace
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

    /**
     * Создание user (manager/cassier)
     *
     * @return array
     */
    public function index(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) : Collection
    {

        /**
         * Получаем User по токену
         * @var User
         *
        */
        $user = $this->authService->getUserAuth();

        /** @var Collection */
        $workspaces = $user->workspaces;

        return $workspaces;
    }

    /**
     * Добавление User к workspace
     * @param mixed $root
     * @param array $args
     * @param GraphQLContext $context
     * @param ResolveInfo $resolveInfo
     *
     * @return bool
     */
    public function addUserWorkspace(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) : User
    {

        /**
         * Получаем User по токену
         * @var User
         *
        */
        $user = $this->authService->getUserAuth();

        /** @var AddUserWorkspaceDTO */
        $addUserWorkspaceDTO = AddUserWorkspaceDTO::make(
            userOwner: $user,
            user: User::find($args['user_id']),
            workspace: Workspace::find($args['workspace_id']),
        );

        /** @var User */
        $user = $this->workspaceService->addUserWorkspace($addUserWorkspaceDTO);

        return $user;
    }

    public function setWorkUserWorkspace(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) : User
    {

        /**
         * Получаем User по токену
         * @var User
         *
        */
        $user = $this->authService->getUserAuth();

        /** @var SetWorkUserWorkspaceDTO */
        $addUserWorkspaceDTO = SetWorkUserWorkspaceDTO::make(
            userOwner: $user,
            user: User::find($args['user_id']),
            workspace: Workspace::find($args['workspace_id']),
        );

        /** @var User */
        $user = $this->workspaceService->setWorkUserWorkspace($addUserWorkspaceDTO);

        return $user;
    }

    public function deleteUserWorkspace(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) : array
    {

        /**
         * Получаем User по токену
         * @var User
         *
        */
        $user = $this->authService->getUserAuth();

        /** @var DeleteUserWorkspaceDTO */
        $deleteUserWorkspaceDTO = DeleteUserWorkspaceDTO::make(
            userOwner: $user,
            user: User::find($args['user_id']),
            workspace: Workspace::find($args['workspace_id']),
        );

        /** @var array */
        $arrayStatus = $this->workspaceService->deleteUserWorkspace($deleteUserWorkspaceDTO);

        return $arrayStatus;
    }



}

