<?php

namespace App\Modules\Drivers\App\Data\DTO\Base;

use App\Modules\Base\Entity\QrEntityBase;

class DynamicQrEntity extends QrEntityBase
{
    public ?int $width; //Ширина изображения (>=200, по умолчанию: 300) [ 200 .. 2000 ]
    public ?int $height; //Высота изображения (>=200, по умолчанию: 300)  [ 200 .. 2000 ]
    public ?string $sourceName; // (Название источника) Cистема, создавшая QR-код
    public ?int $ttl = null; // (Период использования QR-кода в минутах) Задается, только если тип QR = QR-Dynamic
}
