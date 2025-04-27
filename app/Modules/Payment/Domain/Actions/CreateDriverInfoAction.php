<?php

namespace App\Modules\Payment\Domain\Actions;

use Exception;
use function App\Helpers\Mylog;
use App\Modules\Payment\Domain\Models\DriverInfo;
use App\Modules\Payment\App\Data\ValueObject\DriverInfoVO;


class CreateDriverInfoAction
{
    public static function make(DriverInfoVO $vo) : DriverInfo
    {
       return (new self())->run($vo);
    }

    private function run(DriverInfoVO $vo) : DriverInfo
    {


        try {

            $model = DriverInfo::query()->create($vo->toArrayNotNull());

        } catch (\Throwable $th) {
            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new Exception('Ошибка в классе: ' . $nameClass, 500);

        }

        return $model;
    }
}
