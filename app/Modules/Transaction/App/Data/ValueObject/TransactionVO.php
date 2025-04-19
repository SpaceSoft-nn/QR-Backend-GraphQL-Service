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

        public StatusTransactionEnum $status,
        public Money $amount,

        public string $workspace_id,
        public string $qr_code_id,

        public ?string $type_product,
        public ?string $count_product,
        public ?string $name_product,

    ) {}

    public function setQrCodeId(string $qrCodeId) : self
    {
        return self::make(
            status: $this->status,
            amount: new Money($this->amount),

            workspace_id: $this->workspace_id,
            qr_code_id: $qrCodeId,

            type_product: $this->type_product,
            count_product: $this->count_product,
            name_product: $this->name_product,
        );
    }


    public static function make(

        StatusTransactionEnum $status,
        Money $amount,

        string $workspace_id,
        string $qr_code_id,

        ?string $type_product,
        ?string $count_product,
        ?string $name_product,

    ) : self {

        if(is_null($amount)) { $amount = new Money(0); }

        return new self(

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
            "status" => $this->status,
            "amount" => $this->amount,

            "workspace_id" => $this->workspace_id,
            "qr_code_id" => $this->qr_code_id,

            "type_product" => $this->type_product,
            "count_product" => $this->count_product,
            "name_product" => $this->name_product,
        ];
    }

    public static function fromArrayToObject(array $data) : self
    {

        return new self(
            status: Arr::get($data, 'status'),
            amount: Arr::get($data, 'amount'),

            workspace_id: Arr::get($data, 'workspace_id'),
            qr_code_id: Arr::get($data, 'qr_code_id', ''),

            type_product: Arr::get($data, 'type_product', null),
            count_product: Arr::get($data, 'count_product', null),
            name_product: Arr::get($data, 'name_product', null),
        );
    }

}
