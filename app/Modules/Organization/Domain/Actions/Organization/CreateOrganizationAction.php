<?php

namespace App\Modules\Organization\Domain\Actions\Organization;

use Exception;
use function App\Helpers\Mylog;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\Organization\App\Data\ValueObject\OrganizationVO;


class CreateOrganizationAction
{
    public static function make(OrganizationVO $vo) : Organization
    {
       return (new self())->run($vo);
    }

    private function run(OrganizationVO $vo) : Organization
    {

        try {

            $model = Organization::query()->create($vo->toArrayNotNull());

        } catch (\Throwable $th) {
            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new Exception('Ошибка в классе: ' . $nameClass, 500);

        }

        return $model;
    }
}
