<?php

namespace App\Modules\Payment\App\Data\DTO;

use App\Modules\Base\DTO\BaseDTO;
use App\Modules\User\Domain\Models\User;

final class CreateDriverInfoDTO extends BaseDTO
{
    public function __construct(

        public string $key,
        public string $value,
        public string $payment_method_id,
        public string $organization_id,
        public User $user,

    ) { }


    public static function make(

        string $key,
        string $value,
        string $payment_method_id,
        string $organization_id,
        User $user,

    ) : self {

        return new self(
            key: $key,
            value: $value,
            payment_method_id: $payment_method_id,
            organization_id: $organization_id,
            user: $user,
        );

    }
}

