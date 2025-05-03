<?php

namespace App\Modules\Transaction\Presentation\HTTP\Graphql\Response;

use App\Modules\User\Domain\Models\User;
use Nuwave\Lighthouse\Execution\ResolveInfo;
use App\Modules\Auth\Domain\Services\AuthService;
use App\Modules\Workspace\Domain\Models\Workspace;
use App\Modules\Transaction\Domain\Models\Transaction;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Modules\Transaction\App\Data\DTO\TransactionDTO;
use App\Modules\Transaction\App\Data\ValueObject\TransactionVO;
use App\Modules\Transaction\App\Repositories\TransactionRepository;
use App\Modules\Transaction\Domain\Services\TransactionService;
use App\Modules\Transaction\Domain\Services\Factory\TransactionServiceFactory;
use Illuminate\Database\Eloquent\Collection;

class TransactionResolver
{

    public function __construct(
        private AuthService $authService,
        private TransactionServiceFactory $transactionServiceFactory,
        private TransactionRepository $repository,
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

        /**
         * #TODO Нужно кешировать workspace т.к они часто могут запрашиваться
         * Находим Workspace, и указанный платежный метод, у этого workspace
         * @var Workspace
        */
        $workspace = Workspace::findOrFail($args['workspace_id']);


        /**
         * Вызываем фабричный метод для формирование конкретного драйвера платежа: Тинькофф, точка банк и т.д
         * @var TransactionService
         *
        */
        $transactionService = $this->transactionServiceFactory::getPaymentDriverService($workspace->paymentMethod->number_id ?? null, $args);


        /** @var Transaction */
        $transation = $transactionService->createTransaction(TransactionDTO::make(
            transactionVO: TransactionVO::fromArrayToObject($args, $user),
            user: $user,
        ));

        return $transation;
    }

    public function index(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) : Collection
    {
        /** @var Collection|\App\Modules\Transaction\Domain\Models\Transaction[] */
        $transactions = $this->repository->transactionsByWorkspace($args['workspace_id']);


        return $transactions;
    }

}

