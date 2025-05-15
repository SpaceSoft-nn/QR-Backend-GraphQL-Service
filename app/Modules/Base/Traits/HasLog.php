<?php

namespace App\Modules\Base\Traits;

use Illuminate\Support\Facades\Log;

trait HasLog
{
    protected static function bootHasLog() : void
    {
        Log::info('Лог В трейте');
    }
}
