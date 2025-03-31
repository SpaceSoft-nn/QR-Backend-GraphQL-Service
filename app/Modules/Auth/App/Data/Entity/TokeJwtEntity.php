<?php

namespace App\Modules\Auth\App\Data\Entity;

use Illuminate\Contracts\Support\Arrayable;

class TokeJwtEntity implements Arrayable
{
    public function __construct(
        public string $access_token,
        public string $token_type,
        public string $expiresInMinutesAcc,
        public string $expiresInMinutesRef,
    ) { }

    public static function make(

        string $access_token,
        string $token_type,
        string $expiresInMinutesAcc,
        string $expiresInMinutesRef,

    ) : self {

        return new self(
            access_token: $access_token,
            token_type: $token_type,
            expiresInMinutesAcc: $expiresInMinutesAcc,
            expiresInMinutesRef: $expiresInMinutesRef,
        );

    }

    public function toArray()
    {
        return [
            'access_token' => $this->access_token,
            'token_type' => $this->token_type,
            'expires_in_access' => $this->expiresInMinutesAcc,
            'expires_in_refresh' => $this->expiresInMinutesRef,
        ];
    }

}
