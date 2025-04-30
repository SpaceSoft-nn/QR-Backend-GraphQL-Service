<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

if (!function_exists('Mylog'))
{
    function Mylog(string $message, ?string $channel = null) : void
    {
        $backtrace = debug_backtrace();
        // Извлекаем информацию о вызове для уровня выше функции myFunction, то есть самого вызывающего.
        $caller = $backtrace[1];

        Log::channel($channel)->info($message . ' ' . now() . " ------> " . 'Debug backtrace: ' . 'Function called from file: ' . $caller['file'] . ' on line ' . $caller['line']);
    }
}
