<?php

namespace App\Modules\Payment\Presentation\HTTP\Graphql\Response;

use App\Modules\Payment\Domain\Models\DriverInfo;
use Nuwave\Lighthouse\Execution\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;


class DriverInfoResolver
{

    public function __construct() {}


    /**
     * Создание записи апи ключей: key => value
     * @return DriverInfo
     */
    public function createDriverInfo(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) : DriverInfo
    {

        dd($args);
        return new DriverInfo();
    }

}

