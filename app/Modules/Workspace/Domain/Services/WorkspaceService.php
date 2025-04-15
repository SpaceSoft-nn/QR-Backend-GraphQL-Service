<?php

namespace App\Modules\Workspace\Domain\Services;

use App\Modules\User\Domain\Models\User;
use App\Modules\Workspace\Domain\Models\Workspace;
use App\Modules\Workspace\App\Data\DTO\CreateWorkspaceDTO;
use App\Modules\Workspace\App\Data\DTO\AddUserWorkspaceDTO;
use App\Modules\Workspace\Domain\Interface\IWorkspaceService;
use App\Modules\Workspace\Domain\Interactor\CreateWorkspaceInteractor;
use App\Modules\Workspace\Domain\Interactor\AddUserWorkspaceInteractor;

final class WorkspaceService implements IWorkspaceService
{

    public function __construct(
        private CreateWorkspaceInteractor $createWorkspaceInteractor,
        private AddUserWorkspaceInteractor $addUserWorkspaceInteractor,
    ) { }


    public function createWorkspace(CreateWorkspaceDTO $dto) : Workspace
    {
        return $this->createWorkspaceInteractor->make($dto);
    }

    public function addUserWorkspace(AddUserWorkspaceDTO $dto) : User
    {
        return $this->addUserWorkspaceInteractor->make($dto);
    }

}
