<?php

namespace App\Modules\PersonalArea\Domain\Actions\BalanceLog;

use Exception;
use function App\Helpers\Mylog;
use App\Modules\PersonalArea\Domain\Models\BalanceLog;
use App\Modules\PersonalArea\App\Data\ValueObject\BalanceLog\BalanceLogVO;

class CreateBalanceLogAction
{
    public static function make(BalanceLogVO $vo) : BalanceLog
    {
       return (new self())->run($vo);
    }

    private function run(BalanceLogVO $vo) : BalanceLog
    {

        try {

            $model = BalanceLog::query()->create($vo->toArrayNotNull());

        } catch (\Throwable $th) {
            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new Exception('Ошибка в классе: ' . $nameClass, 500);

        }

        return $model;
    }
}
