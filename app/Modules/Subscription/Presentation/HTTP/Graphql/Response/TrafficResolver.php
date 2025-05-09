<?php

namespace App\Modules\Subscription\Presentation\HTTP\Graphql\Response;

use Illuminate\Database\Eloquent\Model;
use App\Modules\User\Domain\Models\User;
use Nuwave\Lighthouse\Execution\ResolveInfo;
use App\Modules\Auth\Domain\Services\AuthService;
use App\Modules\Transaction\Domain\Models\Transaction;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Modules\PersonalArea\Domain\Models\PersonalArea;
use App\Modules\Subscription\App\Data\DTO\SetTariffPackageDTO;
use App\Modules\Subscription\Domain\Models\TariffPackage;
use App\Modules\Subscription\Domain\Services\TariffPackegService;
use App\Modules\Subscription\Domain\Services\TariffPackegeService;
use App\Modules\Subscription\Domain\Services\Base\FactoryTariffService;

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
    public function setTariffPackage(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) : TariffPackage
    {

        /**
         * Получаем User по токену
         * @var User
         *
        */
        $user = $this->authService->getUserAuth();

        /** @var TariffPackegeService */
        $service = $this->factoryTariffService->getServiceTariff('package');

        /** @var TariffPackage*/
        $model = $service->setTariff(
            SetTariffPackageDTO::make(
                user: $user,
                number_id: $args['number_id'],
                personalArea: PersonalArea::findOrFail($args['personal_area_id']),
            )
        );

        dd($model);

        return $model;
    }

}

