<?php

namespace App\Modules\PersonalArea\App\Data\ValueObject;

use Illuminate\Contracts\Support\Arrayable;
use App\Modules\Base\Traits\FilterArrayTrait;


readonly class PersonalAreaVO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(

        public string $subscription_id,
        public string $balance,

    ) {}


    public static function make(

        string $subscription_id,
        string $balance,


    ) : self {

        return new self(
            subscription_id: $subscription_id,
            balance: $balance,
        );

    }

    public function toArray() : array
    {
        return [
            "subscription_id" => $this->subscription_id,
            "balance" => $this->balance,
        ];
    }



}
