<?php

namespace App\Modules\PersonalArea\Domain\Observers;

use function App\Helpers\Mylog;
use App\Modules\Base\Money\Money;
use App\Modules\PersonalArea\Domain\Models\PersonalArea;
use App\Modules\PersonalArea\Domain\Services\BalanceService;
use App\Modules\PersonalArea\App\Data\Enums\OperationBalanceEnum;
use App\Modules\PersonalArea\App\Data\ValueObject\BalanceLog\BalanceLogVO;
use App\Modules\PersonalArea\Domain\Exceptions\PersonalArea\Observer\SavedObserverPersonalAreaException;

use App\Modules\PersonalArea\Domain\Exceptions\PersonalArea\Observer\CreatedObserverPersonalAreaException;

class PersonalAreaObserver
{

    public function __construct(
        private BalanceService $service
    ) { }

    public function created(PersonalArea $personalArea): void
    {

        try {

            $model = $this->service->logBalance(
                BalanceLogVO::make(
                    personal_area_id: $personalArea->id,
                    balance_before: 0,
                    balance_after: 0,
                    amount: 0,
                    operation: OperationBalanceEnum::SETBALANCE,
                )
            );

        } catch (\Throwable $th) {

            #TODO Продумать как поймать последний вызов ошибки throw, а не подымания ошибок по иерарзии
            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при событии сохранения модели в БД: " . $th);
            throw new CreatedObserverPersonalAreaException('Ошибка в классе: ' . $nameClass, 500);

        }
    }


    public function saved(PersonalArea $personalArea): void
    {
        try {

            if(!app()->runningInConsole() && $personalArea->isDirty('balance'))
            {


                /** @var Money */
                $oldBalance = $personalArea->getOriginal('balance');

                /** @var Money */
                $newBalance = $personalArea->balance;

                $status = $oldBalance->sub($newBalance);

                $model = $this->service->logBalance(
                    BalanceLogVO::make(
                        personal_area_id: $personalArea->id,
                        balance_before: $oldBalance,
                        balance_after: $newBalance,
                        amount: trim($oldBalance->sub($newBalance), '-'),
                        operation: $status->gte(0) ? OperationBalanceEnum::WITHDRAWAL : OperationBalanceEnum::DEPOSIT,
                    )
                );
            }

        } catch (\Throwable $th) {

            #TODO Продумать как поймать последний вызов ошибки throw, а не подымания ошибок по иерарзии
            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при событии сохранения модели в БД: " . $th);
            throw new SavedObserverPersonalAreaException('Ошибка в классе: ' . $nameClass, 500);

        }
    }


}
