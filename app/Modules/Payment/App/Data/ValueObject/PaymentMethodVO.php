<?php

namespace App\Modules\Payment\App\Data\ValueObject;

use Illuminate\Contracts\Support\Arrayable;
use App\Modules\Base\Traits\FilterArrayTrait;

readonly class PaymentMethodVO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(

        public bool $active,
        public string $driver_name,
        public string $payment_id,

    ) {}


    public static function make(

        bool $active,
        string $driver_name,
        string $payment_id,


    ) : self {

        return new self(

            active: $active,
            driver_name: $driver_name,
            payment_id: $payment_id,

        );

    }

    public function toArray() : array
    {
        return [
            "active" => $this->active,
            "driver_name" => $this->driver_name,
            "payment_id" => $this->payment_id,
        ];
    }

}
