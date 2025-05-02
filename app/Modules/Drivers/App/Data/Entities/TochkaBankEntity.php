<?php

namespace App\Modules\Drivers\App\Data\Entities;

use Illuminate\Support\Arr;
use App\Modules\Base\Entity\QrEntityBase;
use App\Modules\Transaction\App\Data\Enums\QrTypeEnum;
use App\Modules\Drivers\App\Data\DTO\CreateQrTochkaBankDTO;

class TochkaBankEntity extends QrEntityBase
{

    public static function make(

        string $payload,
        string $qrcId,
        string $content_image_base64,
        string $qrcType,

        ?string $width = null,
        ?string $height = null,
        ?string $sourceName = "QR Prosto",
        ?int $ttl = 4320,

    ) : self {


        $qrcType = QrTypeEnum::from($qrcType);

        if(QrTypeEnum::isStatic($qrcType)) {
            $ttl = null;
        }

        return new self(
            payload: $payload,
            qrcId: $qrcId,
            content_image_base64: $content_image_base64,

            qrcType: $qrcType,

            width: $width,
            height: $height,
            sourceName: $sourceName,
            ttl: $ttl,
        );
    }

    public static function fromArrayToObject(array $data, CreateQrTochkaBankDTO $dto) : self
    {

        $data = $data['Data'];

        return self::make(

            payload: Arr::get($data, 'payload'),
            qrcId: Arr::get($data, 'qrcId'),
            content_image_base64: Arr::get($data['image'], 'content'),

            qrcType: $dto->qrcType->value,
            width: $dto->width,
            height: $dto->height,
            sourceName: $dto->sourceName,
            ttl: $dto->ttl,

        );
    }

}
