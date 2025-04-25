<?php

namespace App\Modules\User\Domain\Factories;

use App\Modules\User\Domain\Models\User;
use App\Modules\User\App\Data\Enums\UserRoleEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Modules\Notification\Domain\Models\EmailList;
use App\Modules\User\App\Data\ValueObject\UserVO;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {

        /**
         * @var EmailList
        */
        // $email = EmailList::factory()->create([
        //     'value' => 'test@mail.ru',
        //     'status' => true,
        // ]);

        $user = UserVO::make(
            first_name: $this->faker->name,
            last_name: $this->faker->name,
            father_name: $this->faker->name,
            password: 'password',
            role: UserRoleEnum::ADMIN,
            active: true
        );

        $arrayUser = $user->toArrayNotNull();


        //P.S addAuthActiveByUser - можно вызывать через factory
        return $this->addAuthActiveByUser($arrayUser);
    }

    public function addAuthActiveByUser(array $user)
    {
        $user['auth'] = true;
        return $user;
    }
}
