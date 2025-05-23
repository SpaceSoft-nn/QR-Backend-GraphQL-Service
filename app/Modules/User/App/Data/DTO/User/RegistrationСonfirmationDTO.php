<?php

namespace App\Modules\User\App\Data\DTO\User;

use App\Modules\Base\DTO\BaseDTO;
use App\Modules\Notification\Domain\Models\SendEmail;

final class RegistrationСonfirmationDTO extends BaseDTO
{
    public function __construct(
        public SendEmail $sendEmail,
    ) {

    }

    public static function make(
        SendEmail $sendEmail,
    ) : self {

        return new self(
            sendEmail: $sendEmail,
        );

    }
}

