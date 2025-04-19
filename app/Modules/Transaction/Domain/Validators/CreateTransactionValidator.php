<?php declare(strict_types=1);

namespace App\Modules\Transaction\Domain\Validators;

use Nuwave\Lighthouse\Validation\Validator;

final class CreateTransactionValidator extends Validator
{
    public function rules(): array
    {
        return [
            "workspace_id" => ['required', 'uuid', 'exists:workspaces,id'],
            "amount" => ['required', 'numeric'],
            "type_product" => ['nullable', 'string'],
            "count_product" => ['nullable', 'integer'],
            "name_product" => ['nullable', 'string'],
        ];
    }

}
