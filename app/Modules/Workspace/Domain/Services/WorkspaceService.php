<?php

namespace App\Modules\Workspace\Domain\Services;

use App\Modules\User\Domain\Models\User;
use App\Modules\Workspace\App\Data\DTO\AddPaymentWorkspaceDTO;
use App\Modules\Workspace\Domain\Models\Workspace;
use App\Modules\Workspace\App\Data\DTO\CreateWorkspaceDTO;
use App\Modules\Workspace\App\Data\DTO\AddUserWorkspaceDTO;
use App\Modules\Workspace\Domain\Interface\IWorkspaceService;
use App\Modules\Workspace\App\Data\DTO\DeleteUserWorkspaceDTO;
use App\Modules\Workspace\App\Data\DTO\SetWorkUserWorkspaceDTO;
use App\Modules\Workspace\Domain\Interactor\AddPaymentWorkspaceInteractor;
use App\Modules\Workspace\Domain\Interactor\SetWorkUserWorkspace;
use App\Modules\Workspace\Domain\Interactor\CreateWorkspaceInteractor;
use App\Modules\Workspace\Domain\Interactor\AddUserWorkspaceInteractor;
use App\Modules\Workspace\Domain\Interactor\DeleteUserWorkspaceInteractor;

final class WorkspaceService implements IWorkspaceService
{

    public function __construct(
        private CreateWorkspaceInteractor $createWorkspaceInteractor,
        private AddUserWorkspaceInteractor $addUserWorkspaceInteractor,
        private SetWorkUserWorkspace $setWorkUserWorkspace,
        private DeleteUserWorkspaceInteractor $deleteUserWorkspaceInteractor,
        private AddPaymentWorkspaceInteractor $addPaymentWorkspaceInteractor,
    ) { }


    public function createWorkspace(CreateWorkspaceDTO $dto) : Workspace
    {
        return $this->createWorkspaceInteractor->make($dto);
    }

    public function addUserWorkspace(AddUserWorkspaceDTO $dto) : User
    {
        return $this->addUserWorkspaceInteractor->make($dto);
    }

    public function setWorkUserWorkspace(SetWorkUserWorkspaceDTO $dto) : User
    {
        return $this->setWorkUserWorkspace->make($dto);
    }

    public function deleteUserWorkspace(DeleteUserWorkspaceDTO $dto) : array
    {
        return $this->deleteUserWorkspaceInteractor->make($dto);
    }

    public function addPaymentWorkspace(AddPaymentWorkspaceDTO $dto) : Workspace
    {
        return $this->addPaymentWorkspaceInteractor->make($dto);
    }

}
