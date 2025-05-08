<?php

namespace App\Modules\Subscription\Presentation\HTTP\Graphql\Response;

use Illuminate\Database\Eloquent\Model;
use Nuwave\Lighthouse\Execution\ResolveInfo;
use App\Modules\Auth\Domain\Services\AuthService;
use App\Modules\Transaction\Domain\Models\Transaction;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class TrafficResolver
{

    public function __construct(
        private AuthService $authService,
    ) {}


    /**
     * Устанавливаем тариф Package
     *
     * @return array
     */
    public function setTariffPackage(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) : Model
    {
        dd($args);

        return new Transaction();
    }

}

