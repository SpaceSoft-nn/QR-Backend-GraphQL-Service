<?php

namespace App\Modules\Transaction\App\Data\DTO;

use App\Modules\Base\DTO\BaseDTO;
use App\Modules\User\Domain\Models\User;
use App\Modules\Base\Traits\FilterArrayTrait;
use App\Modules\Transaction\App\Data\ValueObject\TransactionVO;

final class TransactionDTO extends BaseDTO
{
    use FilterArrayTrait;

    public function __construct(

        public TransactionVO $transactionVO,
        public User $user,
        // public BaseDTO $dtoQr,

    ) {}

    public static function make(

        TransactionVO $transactionVO,
        User $user,
        // BaseDTO $dtoQr,

    ) : self {

        return new self(

            transactionVO: $transactionVO,
            user: $user,
            // dtoQr: $dtoQr,

        );

    }

}


