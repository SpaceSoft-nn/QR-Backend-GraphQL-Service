<?php

namespace App\Modules\User\Domain\Services;

use App\Modules\User\App\Data\DTO\User\CreateUserDTO;
use App\Modules\User\Domain\Models\User;
use App\Modules\User\Domain\Interactor\RegistrationInteractor;
use App\Modules\User\Domain\Interface\Repository\Service\IUserService;

final class UserService implements IUserService
{

    public function __construct(
        private RegistrationInteractor $registrationInteractor
    ) { }


    public function registrationUser(CreateUserDTO $dto) : User
    {
        return $this->registrationInteractor->make($dto);
    }

}
