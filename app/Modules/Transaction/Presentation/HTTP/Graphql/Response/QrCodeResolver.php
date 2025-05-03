<?php

namespace App\Modules\Transaction\Presentation\HTTP\Graphql\Response;

use Nuwave\Lighthouse\Execution\ResolveInfo;
use App\Modules\Auth\Domain\Services\AuthService;
use App\Modules\Transaction\App\Repositories\TransactionRepository;
use App\Modules\Transaction\Domain\Models\Transaction;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class QrCodeResolver
{

    public function __construct(
        private AuthService $authService,
        private TransactionRepository $repository,
    ) {}


    /**
     * Вернуть все qr code у Manager/Admin, или у workspace_id
     *
     * @return array
     */
    public function index(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $transaction = $this->repository->transactionsByWorkspace($args['workspace_id']);


        return new Transaction();
    }

}

