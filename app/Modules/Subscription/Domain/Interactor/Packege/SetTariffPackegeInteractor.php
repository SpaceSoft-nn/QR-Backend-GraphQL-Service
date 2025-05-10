<?php

namespace App\Modules\Subscription\Domain\Interactor\Packege;

use Illuminate\Support\Carbon;
use App\Modules\Base\DTO\BaseDTO;
use App\Modules\Base\Money\Money;
use Illuminate\Support\Facades\DB;
use App\Modules\Base\Interactor\BaseInteractor;
use App\Modules\Base\Error\GraphQLBusinessException;
use App\Modules\PersonalArea\Domain\Models\PersonalArea;
use App\Modules\Subscription\Domain\Models\TariffPackage;
use App\Modules\PersonalArea\Domain\Services\BalanceService;
use App\Modules\Subscription\Domain\Models\SubscriptionPlan;
use App\Modules\Subscription\App\Data\DTO\SetTariffPackageDTO;
use App\Modules\PersonalArea\App\Data\DTO\WithdrawalBalanceDTO;
use App\Modules\Subscription\App\Data\ValueObject\SubscriptionVO;
use App\Modules\Subscription\Domain\Actions\Subscription\UpdateSubscriptionAction;

class SetTariffPackegeInteractor extends BaseInteractor
{

    public function __construct(
        private TariffPackage $tariffPackage,
        private BalanceService $balanceService,
    ) { }


    /**
     * @param SetTariffPackageDTO $dto
     *
     * @return SubscriptionPlan
     */
    public function execute(BaseDTO $dto) : SubscriptionPlan
    {
        $this->checkPermission($dto);

        return $this->run($dto);
    }


    /**
     * @param SetTariffPackageDTO $dto
     *
     * @return SubscriptionPlan
     */
    protected function run(BaseDTO $dto) : SubscriptionPlan
    {

        /** @var TariffPackage */
        $tariffPackage = $this->tariffPackage;

        /** @var PersonalArea */
        $personalArea = $dto->personalArea;

        /** @var SubscriptionPlan */
        $subscription = $personalArea->subscription;


        /** @var SubscriptionPlan */
        $model = DB::transaction(function ($pdo) use ($dto, $tariffPackage, $personalArea, $subscription) {

            $statusBalance = $this->balanceService->withdrawal(WithdrawalBalanceDTO::make(
                moneyDeposit: $tariffPackage->price,
                personalArea: $personalArea,
                user: $dto->user,
            ));

            /** @var SubscriptionVO */
            $subscriptionVO = SubscriptionVO::modelForValueObject($subscription)
                ->setPaymentLimit($tariffPackage->payment_limit)
                ->setCountWorkspace(100)
                ->setExpiresAt(Carbon::now()->addDays($tariffPackage->period)->format('d-m-Y H:i:s'))
                ->setPlanName($tariffPackage->name_tariff)
                ->setPolymorph($tariffPackage->id, get_class($tariffPackage));

            //обновляем данные Subscription
            $status = $this->updateSubscriptionAction($subscription, $subscriptionVO);

            //получаем актуальное состояние
            $subscription->refresh();

            return $subscription;
        });

        return $model;
    }

    private function checkPermission(SetTariffPackageDTO $dto)
    {
        // $this->checkHasTariffForSubscription($dto);
        $this->checkBalance($dto);
    }

    /**
     * Проверяем
     * @return bool
     */
    private function checkHasTariffForSubscription(SetTariffPackageDTO $dto)
    {
        /** @var SubscriptionPlan */
        $sub = $dto->personalArea->subscription;

        $model = $sub->subscriptionable;

        return $model
            ? throw new GraphQLBusinessException("У вас уже имеется активный и оплаченый тариф.", 409)
                : false;
    }

    private function checkBalance(SetTariffPackageDTO $dto)
    {
        /** @var PersonalArea */
        $personalArea = $dto->personalArea;

        /** @var TariffPackage */
        $this->tariffPackage = TariffPackage::where("number_id", $dto->number_id)->first();

        $status = (new Money($personalArea->balance))->gte($this->tariffPackage->price);

        if(!$status) { throw new GraphQLBusinessException("У вас недостаточно средств на балансе.", 402); }

        return true;
    }

    private function updateSubscriptionAction(SubscriptionPlan $sub, SubscriptionVO $vo) : SubscriptionPlan
    {
        return UpdateSubscriptionAction::make($sub, $vo);
    }

}
