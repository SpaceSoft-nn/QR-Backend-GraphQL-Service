<?php

namespace App\Modules\Subscription\Presentation\HTTP\Graphql\Response;

use App\Modules\User\Domain\Models\User;
use Nuwave\Lighthouse\Execution\ResolveInfo;
use App\Modules\Auth\Domain\Services\AuthService;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Modules\PersonalArea\Domain\Models\PersonalArea;
use App\Modules\Subscription\Domain\Models\SubscriptionPlan;
use App\Modules\Subscription\App\Data\DTO\SetTariffPackageDTO;
use App\Modules\Subscription\App\Data\DTO\SetTariffWorkspaceDTO;
use App\Modules\Subscription\Domain\Services\TariffPackegeService;
use App\Modules\Subscription\App\Data\ValueObject\TariffWorkspaceVO;
use App\Modules\Subscription\Domain\Services\TariffWorkspaceService;
use App\Modules\Subscription\Domain\Services\Base\FactoryTariffService;
use App\Modules\Subscription\App\Data\DTO\PriceTariffWorkspaceCalculationDTO;

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

        /**
         * Подсчет цены с учетом скидки + скидка
         * @var array
         *
        */
        $arrayCalculate = $service->priceTariffWorkspaceCalculation(PriceTariffWorkspaceCalculationDTO::make(
            count_workspace: $args['count_workspace'],
            period: $args['period'],
        ));


        /** @var TariffWorkspaceVO */
        $tariffWorkspaceVO = TariffWorkspaceVO::make(
            price: $arrayCalculate['price'],
            price_discount: $arrayCalculate['price_discount'],
            count_workspace: $args['count_workspace'],
            period: $args['period'],
            description: $args['description'],
            discount: $arrayCalculate['discount'],
        );

        /** @var SubscriptionPlan*/
        $model = $service->setTariff(SetTariffWorkspaceDTO::make(
            user: $user,
            tariffWorkspaceVO: $tariffWorkspaceVO,
            personalArea: PersonalArea::find($args['personal_area_id']),
        ));

        // dd($model);

        return $model;
    }

}

