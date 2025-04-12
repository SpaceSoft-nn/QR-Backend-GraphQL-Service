<?php

namespace App\Modules\PersonalArea\App\Data\ValueObject;

use App\Modules\Base\Money\Money;
use Illuminate\Contracts\Support\Arrayable;
use App\Modules\Base\Traits\FilterArrayTrait;


readonly class PersonalAreaVO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(

        public string $subscription_id,
        public string $owner_id,
        public ?Money $balance,

    ) {}


    public static function make(

        string $subscription_id,
        string $owner_id,
        int|string|float|null $balance = null,


    ) : self {

        if(is_null($balance)) { $balance = new Money(0); }

        return new self(
            subscription_id: $subscription_id,
            owner_id: $owner_id,
            balance: new Money($balance),
        );

    }

    public function toArray() : array
    {
        return [
            "subscription_id" => $this->subscription_id,
            "owner_id" => $this->owner_id,
            "balance" => (string) $this->balance,
        ];
    }



}
