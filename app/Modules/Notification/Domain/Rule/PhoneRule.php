<?php

namespace App\Modules\Notification\Domain\Rule;

use App\Modules\Notification\Domain\Rule\Traits\TraitRule;

class PhoneRule
{
    use TraitRule;
    protected array $rules = ["required_without_all:email", "exclude_with:email", "numeric", "regex:/^(7|8)(\d{10})$/"];

}

