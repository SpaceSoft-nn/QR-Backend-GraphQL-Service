<?php

namespace App\Modules\User\Domain\Interactor;

use App\Modules\Base\DTO\BaseDTO;
use Illuminate\Support\Facades\DB;
use App\Modules\User\Domain\Models\User;
use App\Modules\Base\Interactor\BaseInteractor;
use App\Modules\User\App\Data\ValueObject\UserVO;
use App\Modules\PersonalArea\Domain\Models\PersonalArea;
use App\Modules\User\Domain\Actions\User\CreateUserAction;
use App\Modules\User\App\Data\DTO\User\RegistrationUserDTO;
use App\Modules\PersonalArea\App\Data\DTO\CreatePersonalAreaDTO;
use App\Modules\PersonalArea\Domain\Services\PersonalAreaService;
use App\Modules\Subscription\App\Data\ValueObject\SubscriptionVO;
use App\Modules\Subscription\Domain\Actions\Subscription\CreateSubscriptionAction;
use App\Modules\Subscription\Domain\Models\SubscriptionPlan;
use App\Modules\User\App\Data\DTO\Notification\CreateNotificationDTO;

class RegistrationInteractor extends BaseInteractor
{

    public function __construct(
        private NotificationInteractor $notificationInteractor,
        private PersonalAreaService $personalAreaService,
    ) { }


    /**
     * @param RegistrationUserDTO
     *
     * @return User
    */
    public function execute(BaseDTO $dto) : User
    {
        return $this->run($dto);
    }

    /**
     * @param RegistrationUserDTO $dto
     *
     * @return User
     */
    protected function run(BaseDTO $dto) : User
    {
        /** @var User */
        $user = DB::transaction(function ($pdo) use ($dto) {

            /** @var User */
            $user = $this->createUser($dto->userVO);

            //устанавливаем emailList/phoneList - временно без нотификации
            $user = $this->notificationInteractor->execute(CreateNotificationDTO::make(
                user: $user,
                email: $dto->email,
                phone: $dto->phone,
            ));

            /**
             * Создаём личный кабинет для пользователя
             * @var PersonalArea
             *
            */
            $personalArea = $this->personalAreaService->createPersonalArea(
                CreatePersonalAreaDTO::make(
                    personalAreaVO: null,
                    user: $user,
                )
            );

            /**
             * Устанавливаем базову подписку для личного кабинета
             * @var SubscriptionPlan
             */
            $subscription = $this->createSubscriptionPlan(SubscriptionVO::make(
                plan_name: null,
                personal_area_id: $personalArea->id,
                subscriptionable_id: null,
                subscriptionable_type: null,
                count_workspace: null,
                payment_limit: null,
                expires_at: null,
            ));

            return $user->refresh();
        });

        return $user;
    }

    private function createUser(UserVO $userVO) : User
    {
        return CreateUserAction::make($userVO);
    }

    private function createSubscriptionPlan(SubscriptionVO $vo) : SubscriptionPlan
    {
        return CreateSubscriptionAction::make($vo);
    }

}
