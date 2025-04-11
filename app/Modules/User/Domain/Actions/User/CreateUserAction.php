<?php

namespace App\Modules\User\Domain\Actions\User;

use Exception;
use function App\Helpers\Mylog;
use App\Modules\User\Domain\Models\User;

use App\Modules\User\App\Data\ValueObject\UserVO;

class CreateUserAction
{
    public static function make(UserVO $vo) : User
    {
       return (new self())->run($vo);
    }

    private function run(UserVO $vo) : User
    {

        try {

            $model = User::query()->create($vo->toArrayNotNull());

        } catch (\Throwable $th) {
            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new Exception('Ошибка в классе: ' . $nameClass, 500);

        }

        return $model;
    }
}
