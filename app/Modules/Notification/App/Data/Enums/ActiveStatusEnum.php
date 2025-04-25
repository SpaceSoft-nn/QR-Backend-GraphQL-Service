<?php
namespace App\Modules\Notification\App\Data\Enums;


enum ActiveStatusEnum : string
{
    case PENDING = 'PENDING';
    case COMPLETED = 'COMPLETED';
    case EXPIRED = 'EXPIRED';

    public function is(self $status): bool
    {
        return (bool) ($this === $status);
    }

}
