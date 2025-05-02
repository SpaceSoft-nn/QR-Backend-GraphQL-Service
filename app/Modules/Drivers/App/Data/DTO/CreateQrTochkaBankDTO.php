<?php

namespace App\Modules\Drivers\App\Data\DTO;

use App\Modules\Base\DTO\BaseDTO;
use App\Modules\Transaction\App\Data\Enums\QrTypeEnum;

final class CreateQrTochkaBankDTO extends BaseDTO
{
    private function __construct(

        public string $amount, //(Сумма в копейках) Поле обязательно для заполнения, если тип QR = QR-Dynamic
        public string $paymentPurpose, //(Назначение платежа) пример: "Оплата по счету № 1 от 01.01.2021. Без НДС",
        public QrTypeEnum $qrcType, // 01 - QR-Static (QR наклейка) 02 - QR-Dynamic (QR на кассе)

        public ?string $workspace_id = null,


        public ?int $width, //Ширина изображения (>=200, по умолчанию: 300) [ 200 .. 2000 ]
        public ?int $height, //Высота изображения (>=200, по умолчанию: 300)  [ 200 .. 2000 ]
        public ?string $sourceName, // (Название источника) Cистема, создавшая QR-код
        public ?int $ttl = null, // (Период использования QR-кода в минутах) Задается, только если тип QR = QR-Dynamic

    ) { }


    public static function make(

        string $amount,
        string $paymentPurpose,
        string $qrcType,

        ?string $width = null,
        ?string $height = null,
        ?string $sourceName = "QR Prosto",

        ?int $ttl = 4320,
        ?string $workspace_id = null,

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
            workspace_id: $workspace_id,
        );

    }
}

