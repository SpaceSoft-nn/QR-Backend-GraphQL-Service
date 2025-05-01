<?php

namespace App\Modules\Transaction\Presentation\HTTP\Graphql\Response;

use App\Modules\User\Domain\Models\User;
use Nuwave\Lighthouse\Execution\ResolveInfo;
use App\Modules\Auth\Domain\Services\AuthService;
use App\Modules\Drivers\App\Data\DTO\CreateQrDTO;
use App\Modules\Transaction\Domain\Models\Transaction;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Modules\Transaction\App\Data\DTO\TransactionDTO;
use App\Modules\Transaction\App\Data\ValueObject\TransactionVO;
use App\Modules\Transaction\Domain\Services\TransactionService;


class TransactionResolver
{

    public function __construct(
        private TransactionService $transactionService,
        private AuthService $authService,
    ) {}


    /**
     * Создание транзакции
     *
     * @return array
     */
    public function store(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) : Transaction
    {

        /**
         * Получаем User по токену
         * @var User
         *
        */
        $user = $this->authService->getUserAuth();

        /** @var Transaction */
        $transation = $this->transactionService->createTransaction(TransactionDTO::make(
            transactionVO: TransactionVO::fromArrayToObject($args),
            user: $user,
            dtoQr: CreateQrDTO::make(

                amount: $args['amount'],
                paymentPurpose: "",
                qrcType: $args['qr_type'],

                width: $args['width'] ?? null,
                height: $args['height'] ?? null,
                sourceName: $args['sourceName'] ?? null,
                ttl: $args['ttl'] ?? null,
                workspace_id: $args['workspace_id'] ?? null,

            ),
        ));

        return $transation;
    }

}

