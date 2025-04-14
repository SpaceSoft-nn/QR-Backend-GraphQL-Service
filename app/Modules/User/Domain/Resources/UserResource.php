<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "father_name" => $this->father_name,
            "role" => $this->role,
            "permission" => $this->permission,
            "active" => $this->active,
            "auth" => $this->auth,
            // "organizations" => $this->,
            // "personalAreas" => $this->,
            // "emailList" => $this->,
            // "phoneList" => $this->,
            // "email" => $this->,
            // "phone" => $this->,
            // "created_at" => $this->,
            // "updated_at" => $this->,
        ];
    }
}
