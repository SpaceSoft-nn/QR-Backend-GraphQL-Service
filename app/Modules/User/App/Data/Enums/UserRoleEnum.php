<?php

namespace App\Modules\User\App\Data\Enums;

enum UserRoleEnum : string
{
    case admin = 'admin';
    case cassier = 'cassier';
    case manager = 'manager';
}
