<?php

namespace App\Modules\Workspace\App\Data\DTO;

use App\Modules\Base\DTO\BaseDTO;
use App\Modules\User\Domain\Models\User;
use App\Modules\Workspace\Domain\Models\Workspace;

final class AddUserWorkspaceDTO extends BaseDTO
{
    public function __construct(

        public User $userOwner, // user который добавляет (пока что создатель workspaces)
        public User $user, //пользователь который добавляется к workspace
        public Workspace $workspace, //worksapce к которому добавляется пользователь

    ) { }

    public static function make(

        User $userOwner,
        User $user,
        Workspace $workspace,

    ) : self {

        return new self(

            userOwner: $userOwner,
            user: $user,
            workspace: $workspace,

        );

    }
}

