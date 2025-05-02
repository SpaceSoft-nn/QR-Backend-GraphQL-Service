<?php declare(strict_types=1);

namespace App\Modules\Transaction\Domain\Validators;

use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Validation\Validator;
use App\Modules\Transaction\App\Data\Enums\QrTypeEnum;

final class CreateTransactionValidator extends Validator
{
    public function rules(): array
    {



        return [
            "workspace_id" => ['required', 'uuid', 'exists:workspaces,id'],
            "amount" => ['required', 'numeric', "min:1", "max:1000000"],
            "qr_type" => ['required', Rule::enum(QrTypeEnum::class)],

            "ttl" => ['nullable', 'integer', 'min:1', "max:4320"],
            "width" => ['nullable', 'integer', "min:200" , "max:2000"],
            "height" => ['nullable', 'integer', "min:200" , "max:2000"],

            "type_product" => ['nullable', 'string'],
            "count_product" => ['nullable', 'integer'],
            "name_product" => ['nullable', 'string'],
        ];
    }

}
