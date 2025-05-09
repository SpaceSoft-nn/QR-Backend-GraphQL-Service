<?php

namespace App\Modules\Base\Casts;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

//При установки времени - мы устанавливаем для бд в формате 'Y-m-d', при получении мы в возвращаем в ру формате 'd.m.Y'
class RuDateTimeCast implements CastsAttributes
{

    public function get(?Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if(is_null($value)) { return null; };

        $date = Carbon::createFromFormat('Y-m-d H:i:s', $value);

        return $date->format('d-m-Y H:i:s');
    }


    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if(is_null($value)) { return null; };

        $date = Carbon::createFromFormat('d-m-Y H:i:s', $value);

        return $date->format('Y-m-d H:i:s');
    }
}
