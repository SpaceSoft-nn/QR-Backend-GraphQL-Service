<?php

namespace App\Modules\Payment\App\Data\ValueObject;

use Illuminate\Support\Arr;
use Illuminate\Contracts\Support\Arrayable;
use App\Modules\Base\Traits\FilterArrayTrait;

readonly class DriverInfoStorageVO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(

        public string $key,
        public string $value,
        public string $payment_method_id,
        public string $user_organizaion_id,

    ) {}


    public static function make(

        string $key,
        string $value,
        string $payment_method_id,
        string $user_organizaion_id,


    ) : self {

        return new self(

            key: $key,
            value: $value,
            payment_method_id: $payment_method_id,
            user_organizaion_id: $user_organizaion_id,

        );

    }

    public function toArray() : array
    {
        return [
            "key" => $this->key,
            "value" => $this->value,
            "payment_method_id" => $this->payment_method_id,
            "user_organizaion_id" => $this->user_organizaion_id,
        ];
    }

    public static function fromArrayToObject(array $data) : self
    {
        $key = Arr::get($data, 'key');
        $value = Arr::get($data, 'value');
        $payment_method_id = Arr::get($data, 'payment_method_id');
        $user_organizaion_id = Arr::get($data, 'user_organizaion_id');

        return new self(
            key: $key,
            value: $value,
            payment_method_id: $payment_method_id,
            user_organizaion_id: $user_organizaion_id,
        );
    }

}
