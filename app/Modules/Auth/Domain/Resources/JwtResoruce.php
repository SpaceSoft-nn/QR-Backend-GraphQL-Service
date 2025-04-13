<?php

namespace App\Modules\Auth\Domain\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JwtResoruce extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            "access_token" => $this->access_token,
            "token_type" => $this->token_type,
            "expires_in_access" => $this->expiresInMinutesAcc,
            "expires_in_refresh" => $this->expiresInMinutesRef,
        ];
    }
}
