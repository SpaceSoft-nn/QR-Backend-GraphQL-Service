<?php

namespace App\Modules\Transaction\App\Data\ValueObject;

use App\Modules\Base\Money\Money;
use Illuminate\Contracts\Support\Arrayable;
use App\Modules\Base\Traits\FilterArrayTrait;
use App\Modules\Transaction\App\Data\Enums\QrTypeEnum;

readonly class QrCodeVO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(

        public string $transaction_id,
        public string $qr_url,


        public ?QrTypeEnum $qr_type,

        public ?int $ttl,
        public ?int $width,
        public ?int $height,

        public ?string $name_product,
        public ?Money $amount,
        public ?string $content_image_base64,

    ) {}


    public static function make(

        string $transaction_id,
        string $qr_url,
        string $qr_type,

        ?int $ttl,
        ?int $width,
        ?int $height,

        ?Money $amount = null,
        ?string $name_product = null,
        ?string $content_image_base64 = null,


    ) : self {

        if(is_null($amount)) { $amount = new Money(0); }

        return new self(

            transaction_id: $transaction_id,
            qr_url: $qr_url,
            name_product: $name_product,
            amount: new Money($amount),

            qr_type: QrTypeEnum::from($qr_type),
            ttl: $ttl,
            width: $width,
            height: $height,
            content_image_base64: $content_image_base64,

        );

    }

    public function toArray() : array
    {
        return [

            "transaction_id" => $this->transaction_id,
            "qr_url" => $this->qr_url,
            "name_product" => $this->name_product,
            "amount" => $this->amount,

            "qr_type" => $this->qr_type,
            "ttl" => $this->ttl,
            "width" => $this->width,
            "height" => $this->height,
            "content_image_base64" => $this->content_image_base64,

        ];
    }

}
