<?php

namespace App\Modules\User\Domain\Validators;

use Illuminate\Validation\Rules\Password;
use App\Modules\Base\Validator\BaseValidator;
use Illuminate\Validation\ValidationException;
use App\Modules\User\App\Data\ValueObject\UserVO;
use App\Modules\Notification\Domain\Rule\EmailRule;
use App\Modules\Notification\Domain\Rule\PhoneRule;
use App\Modules\User\App\Data\DTO\User\RegistrationUserDTO;

class RegistrationValidator extends BaseValidator
{
    public function rules() : array
    {
        return [
            'email' => (new EmailRule)->toArray(),
            'phone' => (new PhoneRule)->toArray(),
            'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            'first_name' => ['required', 'string', "max:130", 'min:2', 'alpha'],
            'last_name' => ['required', 'string', "max:130", 'min:2', 'alpha'],
            'father_name' => ['required', 'string', "max:130", 'min:2', 'alpha'],
            // 'role' => ['required', 'string', Rule::enum(UserRoleEnum::class)->only([UserRoleEnum::ADMIN, UserRoleEnum::CASSIER, UserRoleEnum::MANAGER])],
            'agreement' => ['required', 'boolean', 'accepted'],
        ];
    }

    protected function afterValidation($args) : bool
    {

        if (isset($args['email']) && isset($args['phone'])) {
            throw ValidationException::withMessages([
                'email' => ['Указать нужно либо только email, либо только phone.'],
                'phone' => ['Указать нужно либо только email, либо только phone.'],
            ]);
        }

        if (!isset($args['email']) && !isset($args['phone'])) {

            throw ValidationException::withMessages([
                'email' => ['Необходимо указать либо email, либо phone.'],
                'phone' => ['Необходимо указать либо email, либо phone.'],
            ]);
        }

        return true;
    }

    public function createUserDTO($args)
    {
        return RegistrationUserDTO::make(
            userVO: UserVO::fromArrayToObject($args),
            email: $args['email'] ?? null,
            phone: $args['phone'] ?? null,
        );
    }
}
