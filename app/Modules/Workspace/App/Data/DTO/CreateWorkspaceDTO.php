<?php

namespace App\Modules\Workspace\App\Data\DTO;

use App\Modules\Base\DTO\BaseDTO;
use App\Modules\User\Domain\Models\User;
use App\Modules\Workspace\App\Data\ValueObject\WorkspaceVO;

final class CreateWorkspaceDTO extends BaseDTO
{
    public function __construct(

        public User $user,
        public WorkspaceVO $workspaceVO,

    ) { }

    public static function make(

        User $user,
        WorkspaceVO $workspaceVO,

    ) : self {

        return new self(

            user: $user,
            workspaceVO: $workspaceVO,

        );

    }
}

