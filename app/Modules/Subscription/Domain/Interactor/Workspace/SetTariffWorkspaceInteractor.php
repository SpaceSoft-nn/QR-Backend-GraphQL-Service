<?php

namespace App\Modules\Subscription\Domain\Interactor\Workspace;

use Illuminate\Support\Carbon;
use App\Modules\Base\DTO\BaseDTO;
use App\Modules\Base\Money\Money;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Modules\Base\Interactor\BaseInteractor;
use App\Modules\Base\Error\GraphQLBusinessException;
use App\Modules\PersonalArea\Domain\Models\PersonalArea;
use App\Modules\Subscription\Domain\Models\TariffWorkspace;
use App\Modules\PersonalArea\Domain\Services\BalanceService;
use App\Modules\Subscription\Domain\Models\SubscriptionPlan;
use App\Modules\Subscription\App\Data\DTO\SetTariffPackageDTO;
use App\Modules\PersonalArea\App\Data\DTO\WithdrawalBalanceDTO;
use App\Modules\Subscription\App\Data\DTO\SetTariffWorkspaceDTO;
use App\Modules\Subscription\App\Data\ValueObject\SubscriptionVO;
use App\Modules\Subscription\App\Data\ValueObject\TariffWorkspaceVO;
use App\Modules\Subscription\Domain\Actions\Tariff\CreateTariffWorkspaceAction;
use App\Modules\Subscription\Domain\Actions\Subscription\UpdateSubscriptionAction;

class SetTariffWorkspaceInteractor extends BaseInteractor
{

    public function __construct(
        private BalanceService $balanceService,
    ) { }


    /**
     * @param SetTariffWorkspaceDTO $dto
     *
     * @return SubscriptionPlan
     */
    public function execute(BaseDTO $dto) : SubscriptionPlan
    {
        $this->checkPermission($dto);

        return $this->run($dto);
    }


    /**
     * @param SetTariffWorkspaceDTO $dto
     *
     * @return SubscriptionPlan
     */
    protected function run(BaseDTO $dto) : SubscriptionPlan
    {
        /** @var SubscriptionPlan */
        $model = DB::transaction(function ($pdo) use ($dto) {

            /** @var TariffWorkspace */
            $tariffWorksapce = $this->createTariffWorksapceAction($dto->tariffWorkspaceVO);

            /** @var PersonalArea */
            $personalArea = $dto->personalArea;

            /** @var SubscriptionPlan */
            $subscription = $personalArea->subscription;

            $statusBalance = $this->balanceService->withdrawal(WithdrawalBalanceDTO::make(
                moneyDeposit: $tariffWorksapce->price_discount,
                personalArea: $personalArea,
                user: $dto->user,
            ));

            /** @var SubscriptionVO */
            $subscriptionVO = SubscriptionVO::modelForValueObject($subscription)
                ->setPaymentLimit(null)
                ->setCountWorkspace($tariffWorksapce->count_workspace)
                ->setExpiresAt(Carbon::now()->addDays($tariffWorksapce->period)->format('d-m-Y H:i:s'))
                ->setPlanName($tariffWorksapce->name_tariff)
                ->setPolymorph($tariffWorksapce->id, get_class($tariffWorksapce));



            //обновляем данные Subscription
            $status = $this->updateSubscriptionAction($subscription, $subscriptionVO);

            //получаем актуальное состояние
            $subscription->refresh();

            return $subscription;
        });

        return $model;
    }

    private function checkPermission(SetTariffWorkspaceDTO $dto)
    {
        // $this->checkHasTariffForSubscription($dto);
        // $this->checkBalance($dto);
        // $this->checkIsAdmin($dto);
        $this->checkUserHasPersonalArea($dto);
    }

    /**
     * Проверяем имеется ли активный тариф (потом надо делать тарифы в очередь)
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

    private function checkBalance(SetTariffWorkspaceDTO $dto)
    {
        /** @var PersonalArea */
        $personalArea = $dto->personalArea;

        /** @var Money */
        $priceWorkspace = $dto->tariffWorkspaceVO->price_discount;

        $status = (new Money($personalArea->balance))->gte($priceWorkspace);

        if(!$status) { throw new GraphQLBusinessException("У вас недостаточно средств на балансе.", 402); }

        return true;
    }

    private function checkIsAdmin(SetTariffWorkspaceDTO $dto) : bool
    {

        Gate::forUser($dto->user)->authorize('userAdmin', [$dto->user]);

        return true;

    }

    /**
     * Принадлежит ли пользователь к PersonalArea
     * @param SetTariffWorkspaceDTO $dto
     *
     * @return bool
     */
    private function checkUserHasPersonalArea(SetTariffWorkspaceDTO $dto) : bool
    {

        Gate::forUser($dto->user)->authorize('userHasPersonalArea', [$dto->personalArea]);

        return true;

    }

    private function updateSubscriptionAction(SubscriptionPlan $sub, SubscriptionVO $vo) : SubscriptionPlan
    {
        return UpdateSubscriptionAction::make($sub, $vo);
    }

    private function createTariffWorksapceAction(TariffWorkspaceVO $vo) : TariffWorkspace
    {
        return CreateTariffWorkspaceAction::make($vo);
    }

}
