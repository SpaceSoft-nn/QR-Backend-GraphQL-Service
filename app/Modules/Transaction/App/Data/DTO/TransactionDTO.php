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

        public TransactionVO $transaction,
        public User $user,

    ) {}

    public static function make(

        TransactionVO $transaction,
        User $user,

    ) : self {

        return new self(

            transaction: $transaction,
            user: $user,

        );

    }

}


