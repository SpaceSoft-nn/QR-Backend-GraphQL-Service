<?php

namespace App\Modules\Subscription\App\Data\Entity;

use Illuminate\Contracts\Support\Arrayable;

class CalculateTariffWorkspaceEntity implements Arrayable {

    public function __construct(
        public string $price,
        public string $price_discount, // Идентификатор QR-кода в СБП
        public string $discount, //Картинка в base64
    ) { }

    public static function make(

        string $price,
        string $price_discount, // Идентификатор QR-кода в СБП
        string $discount, //Картинка в base64

    ) : self {

        return new self(
            price: $price,
            price_discount: $price_discount,
            discount: $discount,
        );

    }

    public function toArray() : array
    {
        return [
            "price" => $this->price,
            "price_discount" => $this->price_discount,
            "discount" => $this->discount,
        ];
    }

}

