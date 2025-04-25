<?php

namespace App\Modules\User\App\Data\Enums;

enum UserRoleEnum : string
{
    case ADMIN = 'ADMIN';
    case CASSIER = 'CASSIER';
    case MANAGER = 'MANAGER';

    public static function isManager(UserRoleEnum $enum) : bool
    {
        return self::MANAGER === $enum;
    }

    public static function isAdmin(UserRoleEnum $enum) : bool
    {
        return self::ADMIN === $enum;
    }
}
