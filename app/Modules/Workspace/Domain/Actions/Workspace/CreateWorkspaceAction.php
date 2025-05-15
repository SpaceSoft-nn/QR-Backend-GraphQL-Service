<?php

namespace App\Modules\Workspace\Domain\Actions\Workspace;

use Exception;
use function App\Helpers\Mylog;
use App\Modules\Workspace\Domain\Models\Workspace;

use App\Modules\Workspace\App\Data\ValueObject\WorkspaceVO;

class CreateWorkspaceAction
{
    public static function make(WorkspaceVO $vo) : Workspace
    {
       return (new self())->run($vo);
    }

    private function run(WorkspaceVO $vo) : Workspace
    {
        try {

            $model = Workspace::query()->create($vo->toArrayNotNull());

        } catch (\Throwable $th) {
            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new Exception('Ошибка в классе: ' . $nameClass, 500);

        }

        return $model;
    }
}
