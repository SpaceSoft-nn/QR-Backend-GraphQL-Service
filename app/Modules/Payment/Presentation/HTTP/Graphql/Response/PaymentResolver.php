<?php

namespace App\Modules\Payment\Presentation\HTTP\Graphql\Response;

use App\Modules\Payment\Domain\Models\DriverInfo;
use Nuwave\Lighthouse\Execution\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;


class PaymentResolver
{

    public function __construct() {}


    /**
     * Создание записи апи ключей
     * @return DriverInfo
    */
    public function index(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) : DriverInfo
    {

        dd(55);
        return new DriverInfo();
    }


}

