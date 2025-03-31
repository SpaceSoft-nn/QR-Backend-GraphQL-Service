<?php

namespace App\Modules\Auth\Presentation\Http\Graphql;

use Illuminate\Container\Container;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

//Кастомный класс валидации как FormRequest но при работе с GraphQL
class GraphqlFormRequest
{

    /**
     * @param string $name название класса нашего кастомного FormRequest
     * @param Request $request request от GraphQL
     * @param array $args
     *
     * @return self
     */
    public static function make(string $name, Request $request, array $args) : FormRequest
    {

        // Проверяем, что переданный класс существует и является подклассом FormRequest
        if (!class_exists($name) || !is_subclass_of($name, FormRequest::class)) {
            throw new \InvalidArgumentException("Класс {$name} должен быть наследником Illuminate\Foundation\Http\FormRequest");
        }

        //создаём переданный объект
        $formRequest = $name::createFromBase($request);

        //очищаем параметры от graphQL запросов
        $formRequest->replace([]);

        // Заполняем его данными обычного ввода
        $formRequest->merge($args);

        $formRequest->setContainer(Container::getInstance());

        // Запускаем валидацию
        $formRequest->validateResolved();

        return $formRequest;
    }

}
