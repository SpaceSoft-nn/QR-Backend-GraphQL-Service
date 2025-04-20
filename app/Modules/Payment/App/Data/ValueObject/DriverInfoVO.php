<?php

namespace App\Modules\Payment\App\Data\ValueObject;

use Illuminate\Contracts\Support\Arrayable;
use App\Modules\Base\Traits\FilterArrayTrait;

readonly class DriverInfoVO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(

        public string $key,
        public string $value,
        public string $payment_method_id,
        public int $user_organization_id,

    ) {}


    public static function make(

        string $key,
        string $value,
        string $payment_method_id,
        int $user_organization_id,


    ) : self {

        return new self(

            key: $key,
            value: $value,
            payment_method_id: $payment_method_id,
            user_organization_id: $user_organization_id,

        );

    }

    public function toArray() : array
    {
        return [
            "key" => $this->key,
            "value" => $this->value,
            "payment_method_id" => $this->payment_method_id,
            "user_organization_id" => $this->user_organization_id,
        ];
    }

}
