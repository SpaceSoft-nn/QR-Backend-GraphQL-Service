<?php

namespace App\Modules\User\Domain\Interactor\User;

use App\Modules\Base\DTO\BaseDTO;
use App\Modules\Base\Error\GraphQLBusinessException;
use Illuminate\Support\Facades\DB;
use App\Modules\User\Domain\Models\User;
use App\Modules\Base\Interactor\BaseInteractor;
use App\Modules\User\App\Data\ValueObject\UserVO;
use App\Modules\User\App\Data\DTO\User\CreateUserDTO;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\PersonalArea\Domain\Models\PersonalArea;
use App\Modules\User\Domain\Actions\User\CreateUserAction;
use App\Modules\Pivot\Domain\Actions\PersonalAreaUser\LinkUserToPersonalAreaAction;
use App\Modules\Pivot\Domain\Actions\UserOrganization\LinkUserToOrganization;
use App\Modules\User\App\Data\DTO\Notification\CreateNotificationDTO;
use App\Modules\User\Domain\Interactor\NotificationInteractor;

class CreateUserInteractor extends BaseInteractor
{

    public function __construct(
        private NotificationInteractor $notificationInteractor,
    ) { }


    /**
     *
     * @param CreateUserDTO $dto
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
        $user = $dto->user;

        /** @var PersonalArea */
        $personalArea = $dto->personalArea;

        /** @var Organization */
        $organization = $dto->organization;

        //проверяем что авторизированный пользователь относится к area и org
        $status = $this->checkLink($user, $personalArea, $organization);

        if(!$status) { throw new GraphQLBusinessException("Ошибка доступа.", 403); }


        /** @var User */
        $user = DB::transaction(function ($pdo) use ($dto, $user, $personalArea, $organization) {

            $userNew = $this->createUser($dto);

            { // Привязываем user к сущностям

                $statusArea = LinkUserToPersonalAreaAction::run($userNew, $personalArea);


                $statusOrganization = LinkUserToOrganization::run($userNew, $organization);


                if(!($statusArea && $statusOrganization)) {
                    throw new GraphQLBusinessException('Ошибка в бизнес логике, при привязки пользователя к лк/орг' ,500);
                }

            }

            return $userNew;
        });

        return $user;
    }

    private function createUser(CreateUserDTO $dto) : User
    {
        /** @var User */
        $user = CreateUserAction::make($dto->userVO);
        
        return $this->linkNotification($dto, $user);
    }

    /**
     * @param CreateUserDTO $dto
     * @param User $user - новый user который создаётся
     *
     * @return User
     */
    private function linkNotification(CreateUserDTO $dto, User $user) : User
    {
        //устанавливаем emailList/phoneList - временно без нотификации
        return $this->notificationInteractor->make(CreateNotificationDTO::make(
            user: $user,
            email: $dto->email,
            phone: $dto->phone,
        ));
    }

    /**
     * Проверяем относится ли данный пользователь к личному кабинету и организации
     * @param User $user
     * @param PersonalArea $personalArea
     * @param Organization $organization
     *
     * @return Bool
     */
    private function checkLink(User $user, PersonalArea $personalArea, Organization $organization) : Bool
    {

        $statusOrg = $user->organizations()
            ->where('organization_id', $organization->id)
            ->exists();

        if(!$statusOrg) { throw new GraphQLBusinessException("Авторизированный пользователь не относится к этой организации", 403); }

        $statusAre = $user->personalAreas()
            ->where('personal_area_id', $personalArea->id)
            ->exists();

        if(!$statusAre) { throw new GraphQLBusinessException("Авторизированный пользователь не относится к этому личному кабинету", 403); }

        return (bool) ($statusAre && $statusOrg);
    }

}
