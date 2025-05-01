<?php

namespace App\Modules\Transaction\App\Data\Enums;

enum QrTypeEnum : string
{
    case DYNAMIC = "DYNAMIC";

    case STATIC = "STATIC";

    public static function isStatic(QrTypeEnum $enum) : bool
    {
        return (bool) $enum === self::STATIC;
    }

    public static function isDinamic(QrTypeEnum $enum) : bool
    {
        return (bool) $enum === self::DYNAMIC;
    }

    public function isNumber() : string
    {
        return match ($this) {
            self::STATIC => "01",
            self::DYNAMIC => "02",
        };
    }

}
