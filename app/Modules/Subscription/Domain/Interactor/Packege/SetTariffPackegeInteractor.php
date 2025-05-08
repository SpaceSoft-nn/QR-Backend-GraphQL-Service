<?php

namespace App\Modules\Subscription\Domain\Interactor\Packege;

use App\Modules\Base\DTO\BaseDTO;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Modules\Base\Interactor\BaseInteractor;
use App\Modules\Base\Error\GraphQLBusinessException;
use App\Modules\PersonalArea\Domain\Models\PersonalArea;
use App\Modules\Subscription\Domain\Models\TariffPackage;
use App\Modules\Subscription\Domain\Models\SubscriptionPlan;
use App\Modules\Subscription\App\Data\DTO\SetTariffPackageDTO;



class SetTariffPackegeInteractor extends BaseInteractor
{

    public function __construct(
        private TariffPackage $tariffPackage,
    ) { }


    /**
     * @param SetTariffPackageDTO $dto
     *
     * @return TariffPackage
     */
    public function execute(BaseDTO $dto) : TariffPackage
    {
        $this->checkPermission($dto);

        return $this->run($dto);
    }


    /**
     * @param SetTariffPackageDTO $dto
     *
     * @return TariffPackage
     */
    protected function run(BaseDTO $dto) : TariffPackage
    {
        /** @var TariffPackage */
        $model = DB::transaction(function ($pdo) use ($dto) {




        });

        return $model;
    }

    private function checkPermission(SetTariffPackageDTO $dto)
    {
        $this->checkHasTariffForSubscription($dto);
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

        /** @var  */
        $tariffPackage = TariffPackage::find($dto->number_id);

        $status = ($personalArea->balance >= $tariffPackage->price) ? true : false;

        dd($status);
    }
}
