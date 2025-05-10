<?php

namespace App\Modules\PersonalArea\Domain\Actions\BalanceLog;

use Exception;
use function App\Helpers\Mylog;
use App\Modules\Base\Money\Money;
use App\Modules\PersonalArea\Domain\Models\PersonalArea;
use App\Modules\PersonalArea\Domain\Exceptions\PersonalArea\UpdateBalancePersonalAreaActionException;

class UpdateBalancePersonalAreaAction
{
    public static function make(PersonalArea $personalArea, Money $balance) : true
    {
       return (new self())->run($personalArea, $balance);
    }

    private function run(PersonalArea $personalArea, Money $balance) : true
    {

        try {

            /**
             * lockForUpdate() - использует для блокировки на момент обновление, и для предовтращения 'гонки' в бд
             * @var PersonalArea
             *
            */
            $personalAreaFresh = PersonalArea::where('id', $personalArea->id)->lockForUpdate()->first();

            $personalAreaFresh->balance = $balance;

            $status = $personalAreaFresh->save();


        } catch (\Throwable $th) {

            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new UpdateBalancePersonalAreaActionException('Ошибка в классе: ' . $nameClass, 500);

        }

        return $status;
    }
}
