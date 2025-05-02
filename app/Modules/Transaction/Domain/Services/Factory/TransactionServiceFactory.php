<?php

namespace App\Modules\Transaction\Domain\Services\Factory;

use App\Modules\Base\Error\GraphQLBusinessException;
use App\Modules\Drivers\Domain\Services\TochkaBankService;
use App\Modules\Transaction\Domain\Services\TransactionService;
use App\Modules\Drivers\Domain\Services\Adapter\TochkaBankServiceAdapter;
use App\Modules\Transaction\Domain\Interface\Service\ITransactionService;
use App\Modules\Transaction\Domain\Interactor\Transaction\CreateTransactionInteractor;

use function App\Helpers\Mylog;

class TransactionServiceFactory
{
    public static function getPaymentDriverService(?int $paymentSystemId, array $args) : ITransactionService
    {
        switch ($paymentSystemId) {

            case '1':
            {
                //Создаём адаптер для сервиса, в адаптере указываем нужное DTO нужное под этот сервис
                $tochkaBankServiceAdapter = TochkaBankServiceAdapter::make(
                    service : app(TochkaBankService::class),
                    args: $args,
                );


                //Создаём экземпляр интерактора для создание транзакции, указываем с каким драйвером платежки мы будем работать
                $createTransactionInteractor = new CreateTransactionInteractor($tochkaBankServiceAdapter);

                //Иницилизируем сервис интерактором
                $transactionService = new TransactionService($createTransactionInteractor);

                return $transactionService;
            }

            case null:
            {
                $nameClass = self::class;
                Mylog("Ошибка в {$nameClass} при выборе платежного драйвера у Workspace:");

                throw new GraphQLBusinessException('Пожалуйста для АРМ - установите выбранный вами платежный метод: Тинькофф, Точка Банк, Сбербанк и т.д ');
                break;
            }

            default :
            {
                $nameClass = self::class;
                Mylog("Ошибка в {$nameClass} при выборе платежного драйвера у Workspace:");

                throw new GraphQLBusinessException('Пожалуйста укажите у АРМ - валидный платежный метод: Тинькофф, Точка Банк, Сбербанк и т.д');
                break;
            }

        }

    }
}
