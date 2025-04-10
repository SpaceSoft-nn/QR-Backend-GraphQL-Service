<?php

namespace App\Modules\User\App\Data\ValueObject;

use Illuminate\Support\Arr;
use Illuminate\Contracts\Support\Arrayable;
use App\Modules\Base\Traits\FilterArrayTrait;
use App\Modules\Auth\App\Data\DTO\Base\BaseDTO;
use App\Modules\User\App\Data\Enums\UserRoleEnum;

class UserVO  extends BaseDTO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $father_name,
        public readonly string $password,

        public readonly UserRoleEnum $role,

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
        ];
    }

}
