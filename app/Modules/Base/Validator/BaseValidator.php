<?php

namespace App\Modules\Base\Validator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Создаем базовый класс валидации если при lighthouse GraphQL надо более гибко управлять валидацией
 */
abstract class BaseValidator
{

    protected ?array $rules;

    //правила валидации laravel
    abstract protected function rules() : array;

    //Валидации после
    protected function beforeValidation($args) : bool { return true; }

    //Валидации До
    protected function afterValidation($args) : bool { return true; }

    public function validate($args) : array
    {

        $this->beforeValidation($args);

        // Стандартная валидация Laravel
        $validator = Validator::make($args, $this->rules());

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $validatedData = $validator->validated();

        $this->afterValidation($args);

        return $validatedData;
    }

    // Вызов валидатора как функции
    public function __invoke(array $data) : array
    {
        return $this->validate($data);
    }

}
