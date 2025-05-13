<?php

namespace App\Modules\PersonalArea\Domain\Actions\BalanceLog;

use function App\Helpers\Mylog;
use App\Modules\Base\Money\Money;
use App\Modules\PersonalArea\Domain\Exceptions\PersonalArea\UpdateBalancePersonalAreaActionException;
use App\Modules\PersonalArea\Domain\Models\PersonalArea;

class UpdateBalancePersonalAreaAction
{
    /**
     * @param PersonalArea $personalArea
     * @param Money $balance
     *
     * @return bool
     */
    public static function make(PersonalArea $personalArea, Money $balance) : bool
    {
       return (new self())->run($personalArea, $balance);
    }

    /**
     * @param PersonalArea $personalArea
     * @param Money $balance
     *
     * @return bool
     */
    private function run(PersonalArea $personalArea, Money $balance) : bool
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
