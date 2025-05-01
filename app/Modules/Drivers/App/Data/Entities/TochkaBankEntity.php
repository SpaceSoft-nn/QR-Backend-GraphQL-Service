<?php

namespace App\Modules\Drivers\App\Data\Entities;

use App\Modules\Base\Entity\QrEntityBase;
use Illuminate\Support\Arr;

class TochkaBankEntity extends QrEntityBase
{
    private function __construct(

        // public ?string $status, // Статус объекта "Active"/"Suspended"
        // public ?string $accountId, //Уникальный и неизменный идентификатор счёта
        // public ?string $createdAt, //Время регистрации
        // public ?string $merchantId, //Идентификатор ТСП
        // public ?string $legalId, // Идентификатор зарегистрированного юрлица в СБП (12 символов)
        // public ?int $commissionPercent, // Размер комиссии в процентах
        // public ?string $ttl, // Период использования в минутах


        public string $payload,
        public string $qrcId, // Идентификатор QR-кода в СБП
        public string $content_image_base64, //Картинка в base64
    ) { }

    public static function make(

        string $payload,
        string $qrcId,
        string $content_image_base64,

        // ?string $ttl = null,
        // ?string $status = null,
        // ?string $accountId = null,
        // ?string $createdAt = null,
        // ?string $merchantId = null,
        // ?string $legalId = null,
        // ?int $commissionPercent = null,

    ) : self {

        return new self(
            payload: $payload,
            qrcId: $qrcId,
            content_image_base64: $content_image_base64,

            // ttl: $ttl,
            // status: $status,
            // accountId: $accountId,
            // createdAt: $createdAt,
            // merchantId: $merchantId,
            // legalId: $legalId,
            // commissionPercent: $commissionPercent,
        );
    }

    public static function fromArrayToObject(array $data) : self
    {

        $data = $data['Data'];

        return new self(

            payload: Arr::get($data, 'payload'),
            qrcId: Arr::get($data, 'qrcId'),
            content_image_base64: Arr::get($data['image'], 'content'),

            // ttl: Arr::get($data, 'ttl', null),
            // status: Arr::get($data, 'ttl', null),
            // accountId:  Arr::get($data, 'ttl', null),
            // createdAt:  Arr::get($data, 'ttl', null),
            // merchantId:  Arr::get($data, 'ttl', null),
            // legalId:  Arr::get($data, 'ttl', null),
            // commissionPercent:  Arr::get($data, 'ttl', null),

        );
    }

}
