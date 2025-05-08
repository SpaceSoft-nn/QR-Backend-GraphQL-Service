<?php

namespace App\Modules\Subscription\Presentation\HTTP\Graphql\Response;

use Illuminate\Database\Eloquent\Model;
use Nuwave\Lighthouse\Execution\ResolveInfo;
use App\Modules\Auth\Domain\Services\AuthService;
use App\Modules\Transaction\Domain\Models\Transaction;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Modules\Subscription\App\Data\DTO\SetTariffPackageDTO;
use App\Modules\Subscription\Domain\Services\TariffPackegService;
use App\Modules\Subscription\Domain\Services\Base\FactoryTariffService;
use App\Modules\User\Domain\Models\User;

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
    public function setTariffPackage(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) : Model
    {

        /**
         * Получаем User по токену
         * @var User
         *
        */
        $user = $this->authService->getUserAuth();

        /** @var TariffPackegService */
        $service = $this->factoryTariffService->getServiceTariff('package');

        $model = $service->setTariff(
            SetTariffPackageDTO::make(
                user: $user,
                number_id: $args['number_id'],
                personal_area_id: $args['personal_area_id'],
            )
        );

        dd(5);

        return new Transaction();
    }

}

