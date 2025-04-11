<?php

namespace App\Modules\User\App\Repositories;

use App\Modules\Base\Interface\Repositories\CoreRepository;
use App\Modules\User\Domain\Interface\Repository\IUserRepository;
use App\Modules\User\Domain\Models\User;

final class UserRepository extends CoreRepository implements IUserRepository
{
    protected function getModelClass()
    {
        return User::class;
    }

    private function query() : \Illuminate\Database\Eloquent\Builder
    {
        return $this->startConditions()->query();
    }

    /**
     * Возвращаем значение email
     * @param User $user
     *
     * @return ?string
     */
    public function email(User $user) : ?string
    {
        return $user->email_list?->value ?? null;
    }

    /**
     * Возвращаем значение phone
     * @param User $user
     *
     * @return ?string
     */
    public function phone(User $user) : ?string
    {
        return $user->phone_list?->value ?? null;
    }
}
