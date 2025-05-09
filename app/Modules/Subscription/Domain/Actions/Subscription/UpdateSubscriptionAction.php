<?php

namespace App\Modules\Subscription\Domain\Actions\Subscription;

use Exception;
use function App\Helpers\Mylog;

use App\Modules\Subscription\Domain\Models\SubscriptionPlan;
use App\Modules\Subscription\App\Data\ValueObject\SubscriptionVO;
use App\Modules\Subscription\Domain\Exceptions\UpdateSubscriptionActionException;

class UpdateSubscriptionAction
{
    public static function make(SubscriptionPlan $sub, SubscriptionVO $vo) : SubscriptionPlan
    {
        return self::run($sub, $vo);
    }

    private static function run(SubscriptionPlan $sub, SubscriptionVO $vo) : SubscriptionPlan
    {

        try {

            //обновляем атрибуты модели через fill
            $sub->fill($vo->toArrayNotNull());

            //проверяем данные на 'грязь' - если данные отличаются от старого состояние модели, то обновляем сущность
            if ($sub->isDirty()) { $sub->save(); $sub->refresh(); }

        } catch (\Throwable $th) {

            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new UpdateSubscriptionActionException('Ошибка в классе: ' . $nameClass, 500);

        }

        return $sub;
    }
}
