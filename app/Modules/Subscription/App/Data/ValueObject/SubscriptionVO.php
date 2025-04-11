<?php

namespace App\Modules\Subscription\App\Data\ValueObject;

use App\Modules\Base\Money\Money;
use Illuminate\Contracts\Support\Arrayable;
use App\Modules\Base\Traits\FilterArrayTrait;

final readonly class SubscriptionVO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(

        public ?string $plan_name,
        public ?Money $price, #здесь нужно делать свой кастомный класс для работы с валютами
        public ?string $expires_at,

    ) {}

    public static function make(

        ?string $plan_name = "basic",
        int|string|float|null $price,
        ?string $expires_at,

    ) : self {

        if(is_null($price)) { $price = new Money(0); }

        return new self(

            plan_name: $plan_name,
            price: $price,
            expires_at: $expires_at,

        );

    }

    public function toArray() : array
    {
        return [
            "plan_name" => $this->plan_name,
            "price" => (string) $this->price,
            "expires_at" => $this->expires_at,
        ];
    }

}


