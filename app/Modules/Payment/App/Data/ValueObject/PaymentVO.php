<?php

namespace App\Modules\Payment\App\Data\ValueObject;

use Illuminate\Support\Arr;
use Illuminate\Contracts\Support\Arrayable;
use App\Modules\Base\Traits\FilterArrayTrait;

readonly class PaymentVO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(

        public bool $status,
        public string $name,

    ) {}


    public static function make(

        bool $status,
        string $name,


    ) : self {

        return new self(

            status: $status,
            name: $name,

        );

    }

    public function toArray() : array
    {
        return [
            "status" => $this->status,
            "name" => $this->name,
        ];
    }

    public static function fromArrayToObject(array $data) : self
    {
        $status = Arr::get($data, 'status');
        $name = Arr::get($data, 'name');

        return new self(
            status: $status,
            name: $name,
        );
    }

}
