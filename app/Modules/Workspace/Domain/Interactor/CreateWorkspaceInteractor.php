<?php

namespace App\Modules\Workspace\Domain\Interactor;

use App\Modules\Base\DTO\BaseDTO;
use Illuminate\Support\Facades\DB;
use App\Modules\User\Domain\Models\User;
use App\Modules\Base\Interactor\BaseInteractor;
use App\Modules\Workspace\Domain\Models\Workspace;
use App\Modules\Workspace\App\Data\DTO\CreateWorkspaceDTO;
use App\Modules\Pivot\Domain\Actions\UserWorkspace\LinkUserToWorkspace;
use App\Modules\Workspace\App\Data\ValueObject\WorkspaceVO;
use App\Modules\Workspace\Domain\Actions\Workspace\CreateWorkspaceAction;

class CreateWorkspaceInteractor extends BaseInteractor
{

    /**
     * @param CreateWorkspaceDTO $dto
     *
     * @return Workspace
     */
    public function make(BaseDTO $dto) : Workspace
    {
        return $this->run($dto);
    }

    /**
     * @param CreateWorkspaceDTO $dto
     *
     * @return Workspace
     */
    protected function run(BaseDTO $dto) : Workspace
    {
        /** @var Workspace */
        $workspace = DB::transaction(function ($pdo) use ($dto) {

            /** @var User */
            $user = $dto->user;

            /** @var Workspace */
            $workspace = $this->createWorkspace($dto->workspaceVO);

            //привязываем user к worksapce через промежуточную таблицу
            $status = LinkUserToWorkspace::run($user, $workspace);

            // return $workspace;
            return $workspace;

        });

        return $workspace;
    }

    private function createWorkspace(WorkspaceVO $vo) : Workspace
    {
        return CreateWorkspaceAction::make($vo);
    }

}
