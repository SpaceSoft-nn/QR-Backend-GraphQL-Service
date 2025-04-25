<?php declare(strict_types=1);

namespace App\Modules\User\Domain\Validators;

use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Validation\Validator;
use App\Modules\User\App\Data\Enums\UserRoleEnum;

final class СhangeRoleUserValidation extends Validator
{
    public function rules(): array
    {
        return [
            "user_id" => ['required', 'uuid', 'exists:users,id'],
            "role" => ['required', Rule::enum(UserRoleEnum::class)],
        ];
    }

}
