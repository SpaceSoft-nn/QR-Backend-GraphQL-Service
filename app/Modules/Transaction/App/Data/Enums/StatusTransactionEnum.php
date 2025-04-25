<?php

namespace App\Modules\Transaction\App\Data\Enums;

enum StatusTransactionEnum : string
{
    case PENDING = 'PENDING';
    case WAITING_FOR_CAPTURE = 'WAITING_FOR_CAPTURE'; //ожидание оплаты
    case COMPLETED = 'COMPLETED';
    case CANCELLED = 'CANCELLED';
}
