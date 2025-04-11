<?php

namespace App\Modules\User\Domain\Interactor;

use App\Modules\Base\DTO\BaseDTO;
use Illuminate\Support\Facades\DB;
use App\Modules\User\Domain\Models\User;
use App\Modules\Base\Interactor\BaseInteractor;
use App\Modules\User\App\Data\ValueObject\UserVO;
use App\Modules\User\App\Data\DTO\User\CreateUserDTO;
use App\Modules\Base\Interface\Interactor\IInteractor;
use App\Modules\User\App\Data\DTO\Notification\CreateNotificationDTO;
use App\Modules\User\Domain\Actions\User\CreateUserAction;


class RegistrationInteractor extends BaseInteractor implements IInteractor
{

    public function __construct(
        private NotificationInteractor $notificationInteractor,
    ) { }


    /**
     * @param CreateUserDTO
     *
     * @return User
    */
    public function make(BaseDTO $dto) : User
    {
        return $this->run($dto);
    }

    /**
     * @param CreateUserDTO $dto
     *
     * @return User
     */
    protected function run(BaseDTO $dto) : User
    {
        /** @var User */
        $user = DB::transaction(function (CreateUserDTO $dto) {

            /** @var User */
            $user = $this->createUser($dto->userVO);

            //устанавливаем email_list/phone_list - временно без нотификации
            $user = $this->notificationInteractor->make(CreateNotificationDTO::make(
                user: $user,
                email: $dto->email,
                phone: $dto->phone,
            ));

                

        });

        return $user;
    }

    private function createUser(UserVO $userVO) : User
    {
        return CreateUserAction::make($userVO);
    }

}
