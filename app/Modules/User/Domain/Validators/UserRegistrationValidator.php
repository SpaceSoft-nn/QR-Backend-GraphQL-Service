<?php declare(strict_types=1);

namespace App\Modules\User\Domain\Validators;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Nuwave\Lighthouse\Validation\Validator;
use Illuminate\Validation\ValidationException;
use App\Modules\User\App\Data\Enums\UserRoleEnum;
use App\Modules\Notification\Domain\Rule\EmailRule;
use App\Modules\Notification\Domain\Rule\PhoneRule;

final class UserRegistrationValidator extends Validator
{
    public function rules(): array
    {
        return [
            'email' => (new EmailRule)->toArray(),
            'phone' => (new PhoneRule)->toArray(),
            'password' => ['required', 'string', Password::defaults(), 'confirmed'],

            'first_name' => ['required', 'string', "max:130", 'min:2', 'alpha'],
            'last_name' => ['required', 'string' , "max:130", 'min:2', 'alpha'],
            'father_name' => ['required', 'string', "max:130", 'min:2', 'alpha'],

            'role' => ['required', 'string', Rule::enum(UserRoleEnum::class)->only([UserRoleEnum::admin, UserRoleEnum::cassier, UserRoleEnum::manager])],

            'agreement' => ['required', 'boolean', 'accepted'],
        ];
    }

    /**
     * Дополнительные проверки после стандартной валидации
     */
    protected function afterValidation(array $args): void
    {

        dd('зашли в валидацию');

        $email = $args['email'] ?? null;
        $phone = $args['phone'] ?? null;

        if (isset($email) && isset($phone)) {
            throw ValidationException::withMessages([
                'email' => ['Указать нужно либо только email, либо только phone.'],
                'phone' => ['Указать нужно либо только email, либо только phone.'],
            ]);
        }

        // Дополнительная проверка, если нужно чтобы хотя бы одно поле было заполнено
        if (!isset($email) && !isset($phone)) {
            throw ValidationException::withMessages([
                'email' => ['Необходимо указать либо email, либо phone.'],
                'phone' => ['Необходимо указать либо email, либо phone.'],
            ]);
        }
    }

}
