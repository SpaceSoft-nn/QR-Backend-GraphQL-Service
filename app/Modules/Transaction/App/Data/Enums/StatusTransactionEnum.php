<?php

namespace App\Modules\Transaction\App\Data\Enums;

enum StatusTransactionEnum : string
{
    case pending = 'pending';
    case waiting_for_capture = 'waiting_for_capture'; //ожидание оплаты
    case completed = 'completed';
    case cancelled = 'cancelled';
}
