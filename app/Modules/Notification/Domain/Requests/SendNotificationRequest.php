<?php

namespace App\Modules\Notification\Domain\Requests;

use App\Modules\Base\Requests\ApiRequest;
use App\Modules\Notification\Domain\Rule\EmailRule;
use App\Modules\Notification\Domain\Rule\PhoneRule;
use Illuminate\Validation\Rule;

class SendNotificationRequest extends ApiRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'type' => ['required', Rule::in(['phone', 'email'])],
            'email' => (new EmailRule)->toArray(),
            'phone' => (new PhoneRule)->toArray(),
        ];
    }
}
