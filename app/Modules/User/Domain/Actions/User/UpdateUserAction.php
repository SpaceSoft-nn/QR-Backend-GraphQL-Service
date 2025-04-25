<?php

namespace App\Modules\User\Domain\Actions\User;

use Exception;
use function App\Helpers\Mylog;
use App\Modules\User\Domain\Models\User;
use App\Modules\User\App\Data\ValueObject\UserVO;


class UpdateUserAction
{
    public static function make(User $model, UserVO $dto) : User
    {
        return app(self::class)->run($model, $dto);
    }

    private function run(User $model, UserVO $dto) : User
    {

        try {

            //обновляем атрибуты модели через fill
            $model->fill($dto->toArrayNotNull());

            //проверяем данные на 'грязь' - если данные отличаются от старого состояние модели, то обновляем сущность
            if ($model->isDirty()) { $model->save(); $model->refresh(); }

        } catch (\Throwable $th) {

            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new Exception('Ошибка в классе: ' . $nameClass, 500);

        }

        return $model;
    }
}
