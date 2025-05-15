<?php

namespace App\Modules\User\App\Data\DTO\User;

use App\Modules\Base\DTO\BaseDTO;
use App\Modules\Notification\Domain\Models\EmailList;
use App\Modules\Notification\Domain\Models\SendEmail;

final class ResetPasswordDTO extends BaseDTO
{
    public function __construct(

        public string $password,
        public SendEmail $sendEmail,

    ) {

    }

    public static function make(

        string $password,
        SendEmail $sendEmail,


    ) : self {

        return new self(

            password: $password,
            sendEmail: $sendEmail,

        );

    }
}

