<?php

namespace App\Modules\PersonalArea\Domain\Actions\PersonalArea;

use Exception;
use function App\Helpers\Mylog;
use App\Modules\PersonalArea\Domain\Models\PersonalArea;
use App\Modules\PersonalArea\App\Data\ValueObject\PersonalAreaVO;

class CreatePersonalAreaAction
{
    public static function make(PersonalAreaVO $vo) : PersonalArea
    {
       return (new self())->run($vo);
    }

    private function run(PersonalAreaVO $vo) : PersonalArea
    {

        try {

            $model = PersonalArea::query()->create($vo->toArrayNotNull());

        } catch (\Throwable $th) {
            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new Exception('Ошибка в классе: ' . $nameClass, 500);

        }

        return $model;
    }
}
