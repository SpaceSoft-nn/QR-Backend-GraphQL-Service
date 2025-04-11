<?php

namespace App\Modules\User\Domain\Validators;

use App\Modules\Auth\Domain\Interface\AuthServiceInterface;
use App\Modules\Base\Requests\ApiRequest;
use App\Modules\Notification\Domain\Rule\EmailRule;
use App\Modules\Notification\Domain\Rule\PhoneRule;
use App\Modules\User\App\Data\DTO\User\ValueObject\UserVO;
use App\Modules\User\App\Data\Enums\UserRoleEnum;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class StandartUserValidator extends ApiRequest
{

    public function authorize(AuthServiceInterface $auth): bool
    {
        #TODO добавить в сервес auth работу с ролями

        /**
        * @var User
        */
        $user = $auth->getUserAuth();
        return UserRoleEnum::onlyAdmin($user->role);
    }

    /**
     * После успешкой валидации делаем ещё проверку.
     * @return [type]
     */
    protected function passedValidation()
    {
        $email = $this->input('email');
        $phone = $this->input('phone');
        //выкидываем ошибку - если у нас прислали email и phone вместе
        abort_if( isset($email) && isset($phone) , 400, 'Only Email or Phone');
    }

    public function rules(): array
    {
        return [
            'email' => (new EmailRule)->toArray(),
            'phone' => (new PhoneRule)->toArray(),
            'password' => ['required', 'string', Password::defaults(), 'confirmed'],

            'first_name' => ['required', 'string', "max:130", 'min:2', 'alpha'],
            'last_name' => ['required', 'string' , "max:130", 'min:2', 'alpha'],
            'father_name' => ['required', 'string', "max:130", 'min:2', 'alpha'],
            'role' => ['required', 'string', Rule::enum(UserRoleEnum::class)->only([UserRoleEnum::manager, UserRoleEnum::observed])],

            'agreement' => ['required', 'boolean'],
        ];
    }

    /**
    * @return UserVO
    */
    public function getValueObject(): UserVO
    {
        return UserVO::fromArrayToObject($this->validated());
    }


}
