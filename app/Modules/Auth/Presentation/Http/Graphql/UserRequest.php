<?php

namespace App\Modules\Auth\Presentation\Http\Graphql;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Логика авторизации (если требуется)
    }

    public function rules(): array
    {
        return [
            "email" => ['nullable', 'email'],
            "phone" => ['nullable', 'string', 'min:5'],
            "password" => ['required', 'string'],
        ];
    }

}
