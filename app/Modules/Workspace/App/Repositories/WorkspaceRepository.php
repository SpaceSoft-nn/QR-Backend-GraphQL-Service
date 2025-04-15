<?php

namespace App\Modules\Workspace\App\Repositories;

use App\Modules\User\Domain\Models\User;
use App\Modules\Workspace\Domain\Models\Workspace;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\Base\Interface\Repositories\CoreRepository;
use App\Modules\Pivot\Domain\Models\UserOrganization;
use App\Modules\Workspace\Domain\Interface\Repository\IWorkspaceRepository;

final class WorkspaceRepository extends CoreRepository implements IWorkspaceRepository
{
    protected function getModelClass()
    {
        return Workspace::class;
    }

    private function query() : \Illuminate\Database\Eloquent\Builder
    {
        return $this->startConditions()->query();
    }

    public function organization(Workspace $workspace) : Organization
    {
        return UserOrganization::find($workspace->user_organization_id)->organization;
    }

    /**
     * Вернуть создателя workspace
     * @param Workspace $workspace
     *
     * @return User
     */
    public function userOwner(Workspace $workspace) : User
    {
        return $workspace->users()->wherePivot('is_owner', true)->first();
    }

    /**
     * Вернуть user - который находится за работой в workspace
     * @param Workspace $workspace
     *
     * @return ?User
     */
    public function userActive(Workspace $workspace) : ?User
    {
        return $workspace->users()->wherePivot('active_user', true)->first();
    }

}
