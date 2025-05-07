<?php

namespace App\Modules\Subscription\App\Data\ValueObject;

use App\Modules\Base\Money\Money;
use Illuminate\Contracts\Support\Arrayable;
use App\Modules\Base\Traits\FilterArrayTrait;
use App\Modules\Subscription\App\Enums\MonthTariffEnum;

final readonly class TariffWorkspaceVO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(

        public string $name_tariff,

        public Money $price,
        public Money $price_discount,

        public int $count_workspace,
        public ?int $discount,

        public ?string $description,

        public MonthTariffEnum $period,

    ) {}

    public static function make(

        ?string $name_tariff = "workspace",

        string $price,
        string $price_discount,
        ?int $discount = 0,

        int $count_workspace,

        ?string $description,

        string $period,


    ) : self {


        return new self(

            name_tariff: $name_tariff,
            price: new Money($price),
            price_discount: new Money($price_discount),
            discount: $discount,
            count_workspace: $count_workspace,
            description: $description,
            period: MonthTariffEnum::from($period),

        );

    }

    public function toArray() : array
    {
        return [

            "name_tariff" => $this->name_tariff,
            "price" => $this->price,
            "price_discount" => $this->price_discount,
            "discount" => $this->discount,
            "count_workspace" => $this->count_workspace,
            "description" => $this->description,
            "period" => $this->period->value,

        ];
    }

}


