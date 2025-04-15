<?php declare(strict_types=1);

namespace App\Modules\Workspace\Domain\Validators;

use Nuwave\Lighthouse\Validation\Validator;

final class AddUserWorkspaceValidator extends Validator
{
    public function rules(): array
    {
        return [
            "user_id" => ['required', 'uuid', "exists:users,id"], //пользователь который добавляется к workspace
            "workspace_id" => ['required', 'uuid', "exists:workspaces,id"], //worksapce к которому добавляется пользователь
        ];
    }

}
