<?php

namespace App\Modules\Notification\Domain\Rule;

use App\Modules\Notification\Domain\Rule\Traits\TraitRule;

class EmailRule
{
    use TraitRule;
    protected array $rules = ["required_without_all:phone", "exclude_with:phone", "string", "email", "max:100"];

}
