<?php

namespace App\Modules\Drivers\App\Data\Enums;

enum QrTypeEnum : string
{
    case dinamic = "dynamic";

    case static = "static";

    public static function isStatic(QrTypeEnum $enum) : bool
    {
        return (bool) $enum === self::static;
    }

    public static function isDinamic(QrTypeEnum $enum) : bool
    {
        return (bool) $enum === self::dinamic;
    }
}
