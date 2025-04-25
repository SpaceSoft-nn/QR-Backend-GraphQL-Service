<?php

namespace App\Modules\Workspace\App\Data\DTO;

use App\Modules\Base\DTO\BaseDTO;
use App\Modules\User\Domain\Models\User;

final class AddPaymentWorkspaceDTO extends BaseDTO
{
    public function __construct(

        public string $payment_method_id,
        public string $workspace_id,
        public User $user,

    ) { }

    public static function make(

        string $payment_method_id,
        string $workspace_id,
        User $user,

    ) : self {

        return new self(

            payment_method_id: $payment_method_id,
            workspace_id: $workspace_id,
            user: $user,

        );

    }
}

