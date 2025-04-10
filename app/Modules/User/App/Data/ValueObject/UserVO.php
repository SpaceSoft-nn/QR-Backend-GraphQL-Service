<?php

namespace App\Modules\User\App\Data\ValueObject;

use Illuminate\Support\Arr;
use Illuminate\Contracts\Support\Arrayable;
use App\Modules\Base\Traits\FilterArrayTrait;
use App\Modules\Auth\App\Data\DTO\Base\BaseDTO;
use App\Modules\User\App\Data\Enums\UserRoleEnum;

readonly class UserVO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(
        public string $first_name,
        public string $last_name,
        public string $father_name,
        public string $password,

        public UserRoleEnum $role,

        public ?string $email,
        public ?string $phone,
        public ?string $email_id,
        public ?string $phone_id,
        public ?bool $active,
    ) {}


    public function setEmailId(string $id) : self
    {
        return $this->make(
            first_name: $this->first_name,
            last_name: $this->last_name,
            father_name: $this->father_name,
            password: $this->password,
            role: $this->role,
            email_id: $id,
            phone_id: $this->phone_id,
            active: $this->active,
            email: $this->email,
            phone: $this->phone,
        );
    }

    public function setPhoneId(string $id) : self
    {

        return $this->make(
            first_name: $this->first_name,
            last_name: $this->last_name,
            father_name: $this->father_name,
            password: $this->password,
            role: $this->role,
            email_id: $this->email_id,
            phone_id: $id,
            active: $this->active,
            email: $this->email,
            phone: $this->phone,
        );
    }

    public function setRole(UserRoleEnum $role)
    {
        return $this->make(
            first_name: $this->first_name,
            last_name: $this->last_name,
            father_name: $this->father_name,
            password: $this->password,
            role: $role,
            email_id: $this->email_id,
            phone_id: $this->phone_id,
            active: $this->active,
            email: $this->email,
            phone: $this->phone,
        );
    }

    public function setActiveUser(bool $active)
    {
        return $this->make(
            first_name: $this->first_name,
            last_name: $this->last_name,
            father_name: $this->father_name,
            password: $this->password,
            role: $this->role,
            email_id: $this->email_id,
            phone_id: $this->phone_id,
            active: $active,
            email: $this->email,
            phone: $this->phone,
        );
    }


    public static function make(

        string $first_name,
        string $last_name,
        string $father_name,
        string $password,
        UserRoleEnum $role,
        ?string $email_id = null,
        ?string $phone_id = null,
        ?string $email = null,
        ?string $phone = null,
        ?bool $active = null,

    ) : self {

        return new self(
            first_name: $first_name,
            last_name: $last_name,
            father_name: $father_name,
            password: $password,
            role: $role,
            email_id: $email_id,
            phone_id: $phone_id,
            active: $active,
            email: $email,
            phone: $phone,
        );

    }

    public function toArray() : array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' =>  $this->last_name,
            'father_name' =>  $this->father_name,
            'password' =>  $this->password,
            'role' =>  $this->role,
            'email_id' =>  $this->email_id,
            'phone_id' =>  $this->phone_id,
            'active' => $this->active,
            'email' => $this->email,
            'phone' => $this->phone,
        ];
    }

}
