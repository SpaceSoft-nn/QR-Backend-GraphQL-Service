<?php

namespace App\Modules\Subscription\Presentation\HTTP\Graphql\Response;

use App\Modules\User\Domain\Models\User;
use Nuwave\Lighthouse\Execution\ResolveInfo;
use App\Modules\Auth\Domain\Services\AuthService;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Modules\PersonalArea\Domain\Models\PersonalArea;
use App\Modules\Subscription\App\Data\DTO\PriceTariffWorkspaceCalculationDTO;
use App\Modules\Subscription\Domain\Models\SubscriptionPlan;
use App\Modules\Subscription\App\Data\DTO\SetTariffPackageDTO;
use App\Modules\Subscription\Domain\Services\TariffPackegeService;
use App\Modules\Subscription\Domain\Services\Base\FactoryTariffService;
use App\Modules\Subscription\Domain\Services\TariffWorkspaceService;

class TrafficResolver
{

    public function __construct(
        private AuthService $authService,
        private FactoryTariffService $factoryTariffService,
    ) {}


    /**
     * Устанавливаем тариф Package
     *
     * @return array
     */
    public function setTariffPackage(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) : SubscriptionPlan
    {

        /**
         * Получаем User по токену
         * @var User
         *
        */
        $user = $this->authService->getUserAuth();

        /** @var TariffPackegeService */
        $service = $this->factoryTariffService->getServiceTariff('package');

        /** @var SubscriptionPlan*/
        $model = $service->setTariff(
            SetTariffPackageDTO::make(
                user: $user,
                number_id: $args['number_id'],
                personalArea: PersonalArea::findOrFail($args['personal_area_id']),
            )
        );

        return $model;
    }

    public function setTariffWorkspace(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) : SubscriptionPlan
    {
        /**
         * Получаем User по токену
         * @var User
         *
        */
        $user = $this->authService->getUserAuth();

        /** @var TariffWorkspaceService */
        $service = $this->factoryTariffService->getServiceTariff('workspace');

        $array = $service->priceTariffWorkspaceCalculation(PriceTariffWorkspaceCalculationDTO::make(
            count_workspace: $args['count_workspace'],
            period: $args['period'],
        ));

        dd($array);

        // $tariffWorkspaceVO = TariffWorkspaceVO::make(

        // );

        /** @var SubscriptionPlan*/
        // $model = $service->setTariff(
        //     SetTariffWorkspaceDTO::make(
        //         user: $user,
        //         TariffWorkspaceVO: ,
        //         PersonalArea: PersonalArea::findOrFail($args['personal_area_id']),
        //     )
        // );

        return new SubscriptionPlan();
    }

}

