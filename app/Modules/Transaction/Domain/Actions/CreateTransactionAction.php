<?php

namespace App\Modules\Transaction\Domain\Actions;

use Exception;
use function App\Helpers\Mylog;
use App\Modules\Transaction\Domain\Models\Transaction;
use App\Modules\Transaction\App\Data\ValueObject\TransactionVO;


class CreateTransactionAction
{
    public static function make(TransactionVO $vo) : Transaction
    {
       return (new self())->run($vo);
    }

    private function run(TransactionVO $vo) : Transaction
    {

        try {

            $model = Transaction::query()->create($vo->toArrayNotNull());

        } catch (\Throwable $th) {
            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new Exception('Ошибка в классе: ' . $nameClass, 500);

        }

        return $model;
    }
}
