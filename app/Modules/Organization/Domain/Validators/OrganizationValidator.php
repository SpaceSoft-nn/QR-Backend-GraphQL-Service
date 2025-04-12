<?php

namespace App\Modules\Organization\Domain\Validators;

use Illuminate\Validation\Rule;
use App\Modules\Base\Validator\BaseValidator;
use App\Modules\Organization\Domain\Rules\OgrnRule;
use App\Modules\Organization\Domain\Rules\OgrnepRule;
use App\Modules\Organization\App\Data\Enums\OrganizationTypeEnum;
use App\Modules\Organization\App\Data\ValueObject\OrganizationVO;

class OrganizationValidator extends BaseValidator
{
    public function rules() : array
    {
        $this->rules = array_merge($this->rules, [

            'name' => ['required' , 'string' , 'max:101' , 'min:2'],
            'address' => ['required' , 'string' , 'max:255' , 'min:12'],
            'phone' => ['nullable' , 'string'],
            'email' => ['nullable', "string", "email:filter", "max:100"],
            'website' => ['nullable', "string"],
            'type' =>  ['required', 'string' , Rule::in(OrganizationTypeEnum::legal, OrganizationTypeEnum::individual)],
            'description' => ['nullable', 'string'],
            'okved' => ['nullable', 'string'],
            'founded_date' => ['nullable', 'date'],
            'inn' => ['required' , 'numeric', 'regex:/^(([0-9]{12})|([0-9]{10}))?$/'],

        ]);

        return $this->rules;
    }

    protected function beforeValidation($args) : bool
    {
        // Если тип ооо, добавляем к правилам валидации kpp и ogrn
        if (OrganizationTypeEnum::from($args['type']) == OrganizationTypeEnum::legal) {
            $this->rules['kpp'] = ['required', 'numeric' , 'regex:/^([0-9]{9})?$/'];
            $this->rules['registration_number'] = ['required' , 'numeric' , 'regex:/^([0-9]{13})?$/' , (new OgrnRule)];
        }

        // если ИП, добавляем огрнип
        if(OrganizationTypeEnum::from($args['type']) == OrganizationTypeEnum::individual )
        {
            $this->rules['registration_number'] = ['required' , 'numeric' , 'regex:/^\d{15}$/', (new OgrnepRule)];
        }

        return true;
    }

    public function createOrganizaionVO(array $args) : OrganizationVO
    {
        return OrganizationVO::fromArrayToObject($args);
    }
}
