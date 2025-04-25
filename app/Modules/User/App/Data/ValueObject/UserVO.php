<?php

namespace App\Modules\User\App\Data\ValueObject;

use Illuminate\Support\Arr;
use Illuminate\Contracts\Support\Arrayable;
use App\Modules\Base\Traits\FilterArrayTrait;
use App\Modules\User\App\Data\Enums\UserRoleEnum;
use App\Modules\User\Domain\Models\User;

readonly class UserVO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(
        public string $first_name,
        public string $last_name,
        public string $father_name,
        public string $password,

        public UserRoleEnum $role,

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

    public static function fromArrayToObject(array $data) : self
    {
        $first_name = Arr::get($data, 'first_name');
        $last_name =  Arr::get($data, 'last_name');
        $father_name =  Arr::get($data, 'father_name');
        $password =  Arr::get($data, 'password');
        $role =  UserRoleEnum::from(Arr::get($data, 'role', 'admin'));
        $email_id = Arr::get($data, 'email_user' , null);
        $phone_id = Arr::get($data, 'phone_user' , null);

        $active = Arr::get($data, 'active' , true);

        if ($first_name === '' || $last_name === '' || $father_name === '' || $password === '') {
            throw new \InvalidArgumentException('Обязательные параметры не могут быть пустыми.', 500);
        }

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

    public static function toValueObject(User $user) : self
    {
        return self::make(
            first_name: $user->first_name,
            last_name: $user->last_name,
            father_name: $user->father_name,
            password: $user->password,
            role: $user->role,
            email_id: $user->email_id,
            phone_id: $user->phone_id,
            active: $user->active,
        );
    }

}
