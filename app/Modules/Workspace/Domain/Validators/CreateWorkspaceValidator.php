<?php declare(strict_types=1);

namespace App\Modules\Workspace\Domain\Validators;

use Nuwave\Lighthouse\Validation\Validator;

final class CreateWorkspaceValidator extends Validator
{
    public function rules(): array
    {
        return [
            "organization_id" => ['required', 'uuid', "exists:organizations,id"],
            "name" => ['required', 'string', 'min:2', 'max:255'],
            "description" => ['nullable', 'string', 'max:65535'],
            "is_active" => ['nullable', 'boolean'],
            "payment_id" => ['nullable', 'uuid', "exists:payments,id"],
        ];
    }

}
