<?php

namespace App\Modules\Drivers\App\Data\DTO;

use App\Modules\Base\DTO\BaseDTO;
use App\Modules\Drivers\App\Data\Enums\QrTypeEnum;

final class CreateQrDTO extends BaseDTO
{
    public function __construct(

        public string $amount, //(Сумма в копейках) Поле обязательно для заполнения, если тип QR = QR-Dynamic
        public string $paymentPurpose, //(Назначение платежа) пример: "Оплата по счету № 1 от 01.01.2021. Без НДС",
        public QrTypeEnum $qrcType, // 01 - QR-Static (QR наклейка) 02 - QR-Dynamic (QR на кассе)

        public ?string $width, //Ширина изображения (>=200, по умолчанию: 300) [ 200 .. 2000 ]
        public ?string $height, //Высота изображения (>=200, по умолчанию: 300)  [ 200 .. 2000 ]
        public ?string $sourceName, // (Название источника) Cистема, создавшая QR-код
        public string $ttl, // (Период использования QR-кода в минутах) Задается, только если тип QR = QR-Dynamic

    ) { }


    public static function make(

        string $amount,
        string $paymentPurpose,
        string $qrcType,
        string $width,
        string $height,
        string $sourceName,
        string $ttl,

    ) : self {

        $qrcType = QrTypeEnum::from($qrcType);

        if(QrTypeEnum::isStatic($qrcType)) {
            $ttl = null;
        }

        return new self(
            amount: $amount,
            paymentPurpose: $paymentPurpose,
            qrcType: $qrcType,
            width: $width,
            height: $height,
            sourceName: $sourceName,
            ttl: $ttl,
        );

    }
}

