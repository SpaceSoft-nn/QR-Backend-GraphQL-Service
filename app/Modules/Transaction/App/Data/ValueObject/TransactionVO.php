<?php

namespace App\Modules\Transaction\App\Data\ValueObject;

use Illuminate\Support\Arr;
use App\Modules\Base\Money\Money;
use Illuminate\Contracts\Support\Arrayable;
use App\Modules\Base\Traits\FilterArrayTrait;
use App\Modules\Transaction\App\Data\Enums\StatusTransactionEnum;

readonly class TransactionVO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(

        public Money $amount,

        public string $workspace_id,

        public ?StatusTransactionEnum $status,
        public ?string $type_product,
        public ?int $count_product,
        public ?string $name_product,

    ) {}


    public static function make(

        string $amount,

        string $workspace_id,

        ?StatusTransactionEnum $status = StatusTransactionEnum::pending,
        ?string $type_product = null,
        ?int $count_product = null,
        ?string $name_product = null,

    ) : self {


        if(is_null($amount)) { $amount = new Money(0); }

        return new self(

            status: $status,
            amount: new Money($amount),

            workspace_id: $workspace_id,

            type_product: $type_product,
            count_product: $count_product,
            name_product: $name_product,

        );

    }

    public function toArray() : array
    {
        return [
            "status" => $this->status->value,
            "amount" => $this->amount,

            "workspace_id" => $this->workspace_id,

            "type_product" => $this->type_product,
            "count_product" => $this->count_product,
            "name_product" => $this->name_product,
        ];
    }

    public static function fromArrayToObject(array $data) : self
    {
        return self::make(
            status: Arr::get($data, 'status', StatusTransactionEnum::pending),
            amount: Arr::get($data, 'amount'),

            workspace_id: Arr::get($data, 'workspace_id'),

            type_product: Arr::get($data, 'type_product', null),
            count_product: Arr::get($data, 'count_product', null),
            name_product: Arr::get($data, 'name_product', null),
        );
    }

}
