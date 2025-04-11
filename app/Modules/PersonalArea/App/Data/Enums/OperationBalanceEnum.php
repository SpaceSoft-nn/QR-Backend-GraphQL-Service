<?php

namespace App\Modules\PersonalArea\App\Data\Enums;

enum OperationBalanceEnum : string
{
    case deposit = 'subtraction'; //пополнение
    case withdrawal = 'addition'; //списание
    case adjustment = 'replenishment'; //корректировка
    case setbalance = 'setbalance'; //первоначальная установка баланса
}
