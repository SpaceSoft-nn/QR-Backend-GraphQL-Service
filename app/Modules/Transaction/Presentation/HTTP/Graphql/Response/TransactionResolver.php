<?php

namespace App\Modules\Transaction\Presentation\HTTP\Graphql\Response;

use App\Modules\Transaction\Domain\Models\Transaction;
use App\Modules\User\Domain\Models\User;
use Nuwave\Lighthouse\Execution\ResolveInfo;
use App\Modules\User\App\Data\DTO\User\CreateUserDTO;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;


class TransactionResolver
{

    public function __construct(

    ) {}


    /**
     * Создание user (manager/cassier)
     *
     * @return array
     */
    public function store(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) : Transaction
    {
        

        return new Transaction();
    }

}

