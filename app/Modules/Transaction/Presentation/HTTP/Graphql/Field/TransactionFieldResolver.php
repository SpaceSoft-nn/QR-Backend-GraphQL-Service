<?php

namespace App\Modules\Transaction\Presentation\HTTP\Graphql\Field;

use App\Modules\Transaction\Domain\Models\Transaction;
use Nuwave\Lighthouse\Execution\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class TransactionFieldResolver
{

    public function amount(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) : ?string
    {
        /** @var Transaction */
        $transaction = $root;

        return $transaction->amount->value;
    }

}
