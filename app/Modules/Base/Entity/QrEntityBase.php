<?php

namespace App\Modules\Base\Entity;

use App\Modules\Transaction\App\Data\Enums\QrTypeEnum;

class QrEntityBase {

    public function __construct(
        public string $payload,
        public string $qrcId, // Идентификатор QR-кода в СБП
        public string $content_image_base64, //Картинка в base64
        public QrTypeEnum $qrcType,

        public ?int $width, //Ширина изображения (>=200, по умолчанию: 300) [ 200 .. 2000 ]
        public ?int $height, //Высота изображения (>=200, по умолчанию: 300)  [ 200 .. 2000 ]
        public ?string $sourceName, // (Название источника) Cистема, создавшая QR-код
        public ?int $ttl = null, // (Период использования QR-кода в минутах) Задается, только если тип QR = QR-Dynamic
    ) {

    }


}

