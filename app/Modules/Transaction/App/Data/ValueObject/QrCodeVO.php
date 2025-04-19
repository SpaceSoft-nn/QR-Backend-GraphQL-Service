<?php

namespace App\Modules\Transaction\App\Data\ValueObject;

use App\Modules\Base\Money\Money;
use Illuminate\Contracts\Support\Arrayable;
use App\Modules\Base\Traits\FilterArrayTrait;

readonly class QrCodeVO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(

        public string $transaction_id,
        public ?string $qr_url,
        public ?string $name_product,
        public ?Money $amount,

    ) {}


    public static function make(

        string $transaction_id,
        ?string $qr_url = 'https://dev.by/storage/images/44/14/12/03/derived/9f1b0cc0fc7967986851e3d3f38e2575.jpg',
        ?string $name_product = null,
        ?Money $amount = null,


    ) : self {

        if(is_null($amount)) { $amount = new Money(0); }

        return new self(

            transaction_id: $transaction_id,
            qr_url: $qr_url,
            name_product: $name_product,
            amount: new Money($amount),

        );

    }

    public function toArray() : array
    {
        return [

            "transaction_id" => $this->transaction_id,
            "qr_url" => $this->qr_url,
            "name_product" => $this->name_product,
            "amount" => $this->amount,

        ];
    }

}
