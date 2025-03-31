<?php declare(strict_types=1);

namespace App\Modules\Auth\Domain\Validators;

use Nuwave\Lighthouse\Validation\Validator;

final class UserLoginValidator extends Validator
{
    public function rules(): array
    {
        return [
            "email" => ['required', 'sometimes', 'email'],
            "phone" => ['nullable', 'string', 'min:5'],
            "password" => ['required'],
        ];
    }

}
