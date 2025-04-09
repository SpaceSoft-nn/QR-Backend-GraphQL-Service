<?php

namespace App\Modules\Notification\Domain\Requests;

use App\Modules\Base\Requests\ApiRequest;
use Illuminate\Validation\Rule;

class ConfirmCodeRequest extends ApiRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'code' => ['required', 'integer', 'min_digits:6', 'max_digits:6'],
            'type' => ['required', Rule::in(['phone', 'email'])],
            'uuid_send' => ['required', 'uuid'],
        ];
    }
}
