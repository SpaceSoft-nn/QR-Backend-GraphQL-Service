<?php

namespace App\Modules\PersonalArea\App\Data\ValueObject\BalanceLog;

use App\Modules\Base\Money\Money;
use Illuminate\Contracts\Support\Arrayable;
use App\Modules\Base\Traits\FilterArrayTrait;
use App\Modules\PersonalArea\App\Data\Enums\OperationBalanceEnum;

readonly class BalanceLogVO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(

        public string $personal_area_id,
        public Money $balance_before,
        public Money $balance_after,
        public Money $amount,
        public OperationBalanceEnum $operation,

    ) {}


    public static function make(

        string $personal_area_id,
        int|string|float $balance_before,
        int|string|float $balance_after,
        int|string|float $amount,
        OperationBalanceEnum $operation


    ) : self {

        return new self(
            personal_area_id: $personal_area_id,
            balance_before: new Money($balance_before),
            balance_after: new Money($balance_after),
            amount: new Money($amount),
            operation: $operation,
        );

    }

    public function toArray() : array
    {
        return [
            "personal_area_id" => $this->personal_area_id,
            "balance_before" => (string) $this->balance_before,
            "balance_after" => (string) $this->balance_after,
            "amount" => (string)$this->amount,
            "operation" => $this->operation->value,
        ];
    }



}
