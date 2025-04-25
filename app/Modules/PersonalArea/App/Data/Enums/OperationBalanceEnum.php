<?php

namespace App\Modules\PersonalArea\App\Data\Enums;

enum OperationBalanceEnum : string
{
    case DEPOSIT = 'DEPOSIT'; //пополнение
    case WITHDRAWAL = 'WITHDRAWAL'; //списание
    case ADJUSTMENT = 'ADJUSTMENT'; //корректировка
    case SETBALANCE = 'SETBALANCE'; //первоначальная установка баланса
}
