<?php

namespace App\Modules\Subscription\App\Data\Enums;

use App\Modules\Base\Money\Money;

enum MonthTariffEnum : int
{
    case ONEMONTH = 1;

    case THREEMONTH = 3;

    case SIXMONTH = 6;

    case TWELVEMONTH = 12;

    /**
     * Возвращает дни в количестве месяца
     * @return int
     */
    public function getDays(): int
    {
        return match($this) {
            self::ONEMONTH => 30,
            self::THREEMONTH => 90,
            self::SIXMONTH => 180,
            self::TWELVEMONTH => 360,
        };
    }

    /**
     * Возвращает дни в количестве месяца
     * @return int
    */
    public static function getMonth(int $days): self
    {
        return match($days) {
            30 => self::ONEMONTH,
            90 => self::THREEMONTH,
            180 => self::SIXMONTH,
            360 => self::TWELVEMONTH,
        };
    }

    /**
     * Возвращаем сумму для 1 workspace по месяцам
     * @return int
    */
    public function getPriceForWorkspace(): Money
    {
        return match($this) {
            self::ONEMONTH => new Money(799),
            self::THREEMONTH => new Money(2199),
            self::SIXMONTH => new Money(4197),
            self::TWELVEMONTH => new Money(7998),
        };
    }

}
