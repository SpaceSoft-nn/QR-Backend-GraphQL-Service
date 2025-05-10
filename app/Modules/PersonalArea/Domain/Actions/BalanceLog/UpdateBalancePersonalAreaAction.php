<?php

namespace App\Modules\PersonalArea\Domain\Actions\BalanceLog;

use Exception;
use function App\Helpers\Mylog;
use App\Modules\Base\Money\Money;
use App\Modules\PersonalArea\Domain\Models\PersonalArea;

class CreatePersonalAreaAction
{
    public static function make(Money $balance) : PersonalArea
    {
       return (new self())->run($balance);
    }

    private function run(Money $balance) : PersonalArea
    {

        try {

            /** @var PersonalArea */
            $model = PersonalArea::query()->update([
                "balance" => $balance,
            ]);

        } catch (\Throwable $th) {
            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new Exception('Ошибка в классе: ' . $nameClass, 500);

        }

        return $model;
    }
}
