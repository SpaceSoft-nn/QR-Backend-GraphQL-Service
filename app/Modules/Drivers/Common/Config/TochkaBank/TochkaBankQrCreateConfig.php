<?php

namespace App\Modules\Drivers\Common\Config\TochkaBank;

use App\Modules\Base\Money\Money;

class TochkaBankQrCreateConfig
{
    private function __construct(

        public string $currency, //(Валюта операции)

        public Money $amount, //Поле обязательно для заполнения, если тип QR = QR-Dynamic

        public array $imageParams, //(Параметры изображения)

        public string $sourceName, //Cистема, создавшая QR-код

        public int $ttl, //Период использования QR-кода в минутах:  Задается, только если тип QR = QR-Dynamic

        public ?string $redirectUrl, //Ссылка для автоматического возврата плательщика из приложения банка в приложение или на сайт ТСП

    ) { }

    public static function make(

        ?string $amount = null,

        ?int $width = 200,

        ?int $height = 200,

        ?string $mediaType = "image/png",

        ?string $sourceName = "Qr Prosto",

        ?int $ttl = 720,

        ?string $redirectUrl = null,

    ) : self {

        if(is_null($amount)) { $amount = new Money(0); }

        return new self(
            currency: "RUB",
            amount: $amount,
            imageParams: [
                "width" => $width,
                "height" => $height,
                "mediaType" => $mediaType
            ],
            sourceName: $sourceName,
            ttl: $ttl,
            redirectUrl: $redirectUrl,
        );
    }

}
