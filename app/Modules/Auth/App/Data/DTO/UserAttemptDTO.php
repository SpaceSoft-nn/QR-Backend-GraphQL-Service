<?php
namespace App\Modules\Auth\App\Data\DTO;

use App\Modules\Auth\App\Data\DTO\Base\BaseDTO;

final class UserAttemptDTO extends BaseDTO
{
    public function __construct(

        public string $password,

        public ?string $phone,

        public ?string $email,

        public ?array $payload

    ) { }

    public static function make(
        string $password,
        ?string $phone = null,
        ?string $email = null,
        ?string $payload = null,
    ) : self {

        if(is_null($payload)) { $payload = []; }

        return new self(
            phone : $phone,
            email : $email,
            password : $password,
            payload : $payload,
        );
    }

    public function toArray(): array {

        $data = [
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => $this->password,
        ];

        //фильтр для удаление значений с null
        $data = collect($data)->filter(function($value){
            return $value !== null;
        })->toArray();

        return $data;
    }

    public function toArrayNotNull() : array
    {
        $arrayFilter = array_filter($this->toArray(), function($value) {
            return !is_null($value);
        });

        return $arrayFilter;
    }

}
