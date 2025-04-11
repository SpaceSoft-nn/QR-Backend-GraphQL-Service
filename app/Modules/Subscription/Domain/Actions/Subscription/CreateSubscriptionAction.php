<?php

namespace App\Modules\Subscription\Domain\Actions\Subscription;

use Exception;
use function App\Helpers\Mylog;
use App\Modules\Subscription\Domain\Models\SubscriptionPlan;
use App\Modules\Subscription\App\Data\ValueObject\SubscriptionVO;


class CreateSubscriptionAction
{
    public static function make(SubscriptionVO $vo) : SubscriptionPlan
    {
       return (new self())->run($vo);
    }

    private function run(SubscriptionVO $vo) : SubscriptionPlan
    {

        try {

            $model = SubscriptionPlan::query()->firstOrCreate(
                ['name' => 'Basic']
                []
            );

        } catch (\Throwable $th) {
            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new Exception('Ошибка в классе: ' . $nameClass, 500);

        }

        return $model;
    }
}
