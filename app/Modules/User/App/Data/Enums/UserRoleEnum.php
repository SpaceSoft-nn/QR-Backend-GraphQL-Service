<?php

namespace App\Modules\User\App\Data\Enums;

enum UserRoleEnum : string
{
    case admin = 'admin';
    case cassier = 'cassier';
    case manager = 'manager';

    public static function isManager(UserRoleEnum $enum) : bool
    {
        return self::manager === $enum;
    }

    public static function isAdmin(UserRoleEnum $enum) : bool
    {
        return self::admin === $enum;
    }
}
