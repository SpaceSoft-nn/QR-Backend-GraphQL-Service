<?php

namespace App\Modules\Subscription\Domain\Actions\Tariff;

use Exception;
use function App\Helpers\Mylog;
use App\Modules\Subscription\Domain\Models\TariffWorkspace;
use App\Modules\Subscription\App\Data\ValueObject\TariffWorkspaceVO;

class CreateTariffWorkspaceAction
{
    public static function make(TariffWorkspaceVO $vo) : TariffWorkspace
    {
       return (new self())->run($vo);
    }

    private function run(TariffWorkspaceVO $vo) : TariffWorkspace
    {

        try {

            $model = TariffWorkspace::query()->firstOrCreate($vo->toArrayNotNull());

        } catch (\Throwable $th) {

            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new Exception('Ошибка в классе: ' . $nameClass, 500);

        }

        return $model;
    }
}
