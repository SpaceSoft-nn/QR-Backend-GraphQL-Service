<?php

namespace App\Modules\Workspace\Domain\Services;

use App\Modules\User\Domain\Models\User;
use App\Modules\Workspace\Domain\Interface\IWorkspaceService;
use App\Modules\Workspace\Domain\Models\Workspace;

final class WorkspaceService implements IWorkspaceService
{

    public function __construct(

    ) { }


    public function createWorkspace() : Workspace
    {
        return new Workspace();
    }

}
