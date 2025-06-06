<?php

namespace App\Modules\User\Domain\Services;

use Illuminate\Support\Facades\Hash;
use App\Modules\User\Domain\Models\User;
use App\Modules\Base\Error\GraphQLBusinessException;
use App\Modules\User\App\Data\DTO\User\LoginUserDTO;
use App\Modules\Notification\Domain\Models\EmailList;
use App\Modules\Notification\Domain\Models\PhoneList;
use App\Modules\User\App\Data\DTO\User\CreateUserDTO;
use App\Modules\User\App\Data\DTO\User\UpdateUserDTO;
use App\Modules\User\App\Data\DTO\User\ResetPasswordDTO;
use App\Modules\User\App\Data\DTO\User\RegistrationUserDTO;
use App\Modules\User\Domain\Interactor\RegistrationInteractor;
use App\Modules\User\Domain\Interactor\User\CreateUserInteractor;
use App\Modules\User\Domain\Interactor\User\UpdateUserInteractor;
use App\Modules\User\App\Data\DTO\User\RegistrationСonfirmationDTO;
use App\Modules\User\Domain\Interactor\User\ResetPasswordInteractor;
use App\Modules\User\Domain\Interface\Repository\Service\IUserService;
use App\Modules\User\Domain\Interactor\User\RegistrationСonfirmationInteractor;

final class UserService implements IUserService
{

    public function __construct(
        private RegistrationInteractor $registrationInteractor,
        private CreateUserInteractor $createUserInteractor,
        private UpdateUserInteractor $updateUserInteractor,
        private ResetPasswordInteractor $resetPasswordInteractor,
        private RegistrationСonfirmationInteractor $registrationСonfirmationInteractor,
    ) { }


    public function registrationUser(RegistrationUserDTO $dto) : User
    {
        return $this->registrationInteractor->execute($dto);
    }

    /**
     * Подтвреждения регистрации аккаунта после нотификации кода
     *
     * @param RegistrationСonfirmationDTO $dto
     *
     * @return User
    */
    public function registrationСonfirmation(RegistrationСonfirmationDTO $dto) : User
    {
        return $this->registrationСonfirmationInteractor->execute($dto);
    }

    public function loginUser(LoginUserDTO $loginUserDTO) : User
    {

        if(!is_null($loginUserDTO->phone)){

            /** @var PhoneList */
            $phone = PhoneList::query()->where('value', $loginUserDTO->phone)->first();

            /** @var User */
            $user = $phone->user;

        } else {

            /** @var EmailList */
            $email = EmailList::query()->where('value', $loginUserDTO->email)->first();

            /** @var User */
            $user = $email->user;

        }

        if (Hash::check($loginUserDTO->password, $user->password)) {

            //если парль верный
            return $user;

        } else {
            // Пароль неверный
            throw new GraphQLBusinessException('Пароль или email/phone неверный.');
        }
    }

    /**
     * Создание user (manager/cassier)
     *
     * @param CreateUserDTO $dto
     *
     * @return User
     */
    public function createUser(CreateUserDTO $dto) : User
    {
        return $this->createUserInteractor->execute($dto);
    }

    public function updateUser(UpdateUserDTO $dto) : User
    {
        return $this->updateUserInteractor->execute($dto);
    }

    public function resetPassword(ResetPasswordDTO $dto) : User
    {
        return $this->resetPasswordInteractor->execute($dto);
    }

}
