<?php

namespace App\Modules\PersonalArea\Domain\Interactor;

use App\Modules\Base\DTO\BaseDTO;
use Illuminate\Support\Facades\DB;
use App\Modules\User\Domain\Models\User;
use App\Modules\Base\Interactor\BaseInteractor;
use App\Modules\PersonalArea\Domain\Models\BalanceLog;
use App\Modules\PersonalArea\Domain\Models\PersonalArea;
use App\Modules\Subscription\Domain\Models\SubscriptionPlan;
use App\Modules\PersonalArea\App\Data\DTO\CreatePersonalAreaDTO;
use App\Modules\PersonalArea\App\Data\Enums\OperationBalanceEnum;
use App\Modules\PersonalArea\App\Data\ValueObject\PersonalAreaVO;
use App\Modules\Subscription\App\Data\ValueObject\SubscriptionVO;
use App\Modules\PersonalArea\App\Data\ValueObject\BalanceLog\BalanceLogVO;
use App\Modules\PersonalArea\Domain\Actions\BalanceLog\CreateBalanceLogAction;
use App\Modules\PersonalArea\Domain\Actions\PersonalArea\CreatePersonalAreaAction;
use App\Modules\Pivot\Domain\Actions\PersonalAreaUser\LinkUserToPersonalAreaAction;
use App\Modules\Subscription\Domain\Actions\Subscription\CreateSubscriptionAction;

class CreatePersonalAreaInteractor extends BaseInteractor
{

    /**
     * @param CreatePersonalAreaDTO $dto
     *
     * @return PersonalArea
     */
    public function execute(BaseDTO $dto) : PersonalArea
    {
        return $this->run($dto);
    }


    /**
     * @param CreatePersonalAreaDTO $dto
     *
     * @return PersonalArea
     */
    protected function run(BaseDTO $dto) : PersonalArea
    {

        /** @var PersonalArea */
        $model = DB::transaction(function ($pdo) use($dto) {


            /** @var User */
            $user = $dto->user;

            /**
             * Задаём первоначальный баланс равным 0
             * @var int
            */
            $balance = 0;

            /** @var SubscriptionPlan */
            $subscriptionPlan = $this->createSubscription(
                SubscriptionVO::make()
            );


            /** @var PersonalArea */
            $personalArea = $this->createPersonalArea(
                PersonalAreaVO::make(
                    subscription_id: $subscriptionPlan->id,
                    owner_id: $user->id,
                    balance: $balance,
                )
            );

            /**
             * записываем первоначальный лог баланс
             *  @var BalanceLog
            */
            $balanceLog = $this->createBalanceLog(BalanceLogVO::make(
                personal_area_id: $personalArea->id,
                balance_before: $balance,
                balance_after: $balance,
                amount: $balance,
                operation: OperationBalanceEnum::setbalance,
            ));

            //устанавливаем связь многие ко многим
            $status = LinkUserToPersonalAreaAction::run($user, $personalArea);

            return $personalArea;
        });

        return $model;
    }

    private function createPersonalArea(PersonalAreaVO $personalAreaVO) : PersonalArea
    {
        return CreatePersonalAreaAction::make($personalAreaVO);
    }

    private function createBalanceLog(BalanceLogVO $balanceLogVO) : BalanceLog
    {
        return CreateBalanceLogAction::make($balanceLogVO);
    }

    private function createSubscription(SubscriptionVO $subscriptionVO) : SubscriptionPlan
    {
        return CreateSubscriptionAction::make($subscriptionVO);
    }
}
