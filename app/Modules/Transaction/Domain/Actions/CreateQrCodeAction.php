<?php

namespace App\Modules\Transaction\Domain\Actions;

use Exception;
use function App\Helpers\Mylog;
use App\Modules\Transaction\Domain\Models\QrCode;
use App\Modules\Transaction\App\Data\ValueObject\QrCodeVO;


class CreateQrCodeAction
{
    public static function make(QrCodeVO $vo) : QrCode
    {
       return (new self())->run($vo);
    }

    private function run(QrCodeVO $vo) : QrCode
    {

        try {

            $model = QrCode::query()->create($vo->toArrayNotNull());

        } catch (\Throwable $th) {
            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new Exception('Ошибка в классе: ' . $nameClass, 500);

        }

        return $model;
    }
}
