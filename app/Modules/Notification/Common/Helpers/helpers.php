<?php

namespace App\Modules\Notification\Common\Helpers;

use Ramsey\Uuid\Uuid;

if (!function_exists('uuid')) {
    function uuid(string $path = '') : string
    {
        /**
         * Добавлен uuid v6 за место v4, т.к у v6 есть сортировка прямо в начале записи по времени,
         * и можно будет отсортирововать в бд по uuid более правильно, но не стоит забывать про подводные
         * камни и колизии, например если есть несколько серверов с разным серверным временем
         */
        return Uuid::uuid6()->toString();
    }
}


if (!function_exists('code')) {
    function code() : int
    {
        return rand(100_000, 999_999);
    }
}

