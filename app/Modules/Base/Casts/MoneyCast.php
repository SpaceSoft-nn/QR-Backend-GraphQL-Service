<?php

namespace App\Modules\Base\Casts;

use App\Modules\Base\Money\Money;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class MoneyCast implements CastsAttributes
{

    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return new Money($value);
    }


    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return (string) new Money($value);
    }
}
