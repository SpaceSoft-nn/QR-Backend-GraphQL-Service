<?php

namespace App\Modules\Payment\Presentation\HTTP\Graphql\Response;

use App\Modules\Auth\Domain\Services\AuthService;
use App\Modules\Payment\App\Data\DTO\CreateDriverInfoDTO;
use App\Modules\Payment\App\Repositories\DriverInfoRepository;
use App\Modules\Payment\Domain\Models\DriverInfo;
use App\Modules\Payment\Domain\Services\PaymentService;
use App\Modules\User\Domain\Models\User;
use Nuwave\Lighthouse\Execution\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;


class DriverInfoResolver
{

    public function __construct(
        private PaymentService $paymentService,
        private AuthService $authService,
        private DriverInfoRepository $driverInfoRepository,
    ) {}


    /**
     * Создание записи апи ключей: key => value
     * @return DriverInfo
     */
    public function createDriverInfo(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) : DriverInfo
    {
        /**
         * Получаем User по токену
         * @var User
         *
        */
        $user = $this->authService->getUserAuth();

        /** @var DriverInfo */
        $driverInfo = $this->paymentService->createDriverInfo(CreateDriverInfoDTO::make(
            key: $args['key'],
            value: $args['value'],
            payment_method_id: $args['payment_method_id'],
            organization_id: $args['organization_id'],
            user: $user,
        ));

        return $driverInfo;
    }

    /**
     * Создание записи апи ключей: key => value
     * @return ?DriverInfo
     */
    public function driverInfoByOrganizationId(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) : ?DriverInfo
    {
        $args = $args['input'];

        /**
         * Получаем User по токену
         * @var User
         *
        */
        $user = $this->authService->getUserAuth();

        return $this->driverInfoRepository->driverInfoByOrganizationId($args['organization_id'], $args['payment_method_id'], $user->id);
    }

}

