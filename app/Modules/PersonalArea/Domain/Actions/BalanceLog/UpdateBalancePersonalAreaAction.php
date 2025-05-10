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

            /** @var true */
            $status = $personalArea->update([
                "balance" => $balance,
            ]);


        } catch (\Throwable $th) {

            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new UpdateBalancePersonalAreaActionException('Ошибка в классе: ' . $nameClass, 500);

        }

        return $status;
    }
}
