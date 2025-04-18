<?php declare(strict_types=1);

namespace App\Modules\Payment\Domain\Validators;

use Nuwave\Lighthouse\Validation\Validator;

final class CreateDriverInfoValidator extends Validator
{
    public function rules(): array
    {
        return [
            "key" => ['required', 'string'],
            "value" => ['required', 'string'],
            "organizaion_id" => ['required', 'uuid', 'exists:organizations,id'],
            "payment_method_id" => ['required', 'uuid', 'exists:payment_methods,id'],
        ];
    }

}
