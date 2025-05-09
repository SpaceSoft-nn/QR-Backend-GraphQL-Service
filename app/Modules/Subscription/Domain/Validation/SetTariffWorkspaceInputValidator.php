<?php declare(strict_types=1);

namespace App\Modules\Subscription\Domain\Validation;

use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Validation\Validator;
use App\Modules\Subscription\App\Data\Enums\MonthTariffEnum;

final class SetTariffWorkspaceInputValidator extends Validator
{
    public function rules(): array
    {
        return [
            "count_workspace" => ['required', 'integer', "min:1"],
            "period" => ['required', 'integer', 'in:30,90,180,360'],
            "description" => ['string', 'nullable', 'max:1000'],
        ];
    }

}
