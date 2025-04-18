<?php

namespace App\Modules\Transaction\App\Data\DTO;

use App\Modules\Base\Money\Money;
use Illuminate\Contracts\Support\Arrayable;
use App\Modules\Base\Traits\FilterArrayTrait;

final readonly class TransactionDTO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(

        public string $plan_name,
        public string $nubmer_uuid,

        public bool $status,

        public Money $amount,

        public string $workspace_id,
        public string $qr_code_id,

        public ?string $type_product,
        public ?string $count_product,
        public ?string $name_product,


    ) {}

    public static function make(

        string $plan_name,
        string $nubmer_uuid,

        bool $status,

        int|string|float $amount,

        string $workspace_id,
        string $qr_code_id,

        ?string $type_product,
        ?string $count_product,
        ?string $name_product,


    ) : self {

        if(is_null($amount)) { $amount = new Money(0); }


        return new self(

            plan_name: $plan_name,
            nubmer_uuid: $nubmer_uuid,
            status: $status,
            amount: new Money($amount),

            workspace_id: $workspace_id,
            qr_code_id: $qr_code_id,
            type_product: $type_product,
            count_product: $count_product,
            name_product: $name_product,

        );

    }

    public function toArray() : array
    {
        return [
            "plan_name" => $this->plan_name,
            "nubmer_uuid" => $this->nubmer_uuid,
            "status" => $this->status,
            "amount" => $this->amount,
            "workspace_id" => $this->workspace_id,
            "qr_code_id" => $this->qr_code_id,
            "type_product" => $this->type_product,
            "count_product" => $this->count_product,
            "name_product" => $this->name_product,
        ];
    }

}


