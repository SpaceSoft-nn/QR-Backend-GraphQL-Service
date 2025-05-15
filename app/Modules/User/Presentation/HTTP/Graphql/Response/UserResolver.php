<?php

namespace App\Modules\User\Presentation\HTTP\Graphql\Response;

use App\Modules\User\Domain\Models\User;
use Nuwave\Lighthouse\Execution\ResolveInfo;
use App\Modules\Auth\Domain\Services\AuthService;
use App\Modules\User\Domain\Services\UserService;
use App\Modules\User\App\Data\DTO\User\CreateUserDTO;
use App\Modules\User\App\Data\DTO\User\UpdateUserDTO;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Modules\User\Domain\Validators\CreateUserValidator;


class UserResolver
{

    public function __construct(
        private CreateUserValidator $userValidator,
        private UserService $userService,
        private AuthService $authService,
    ) {}


    /**
     * Создание user (manager/cassier)
     *
     * @return array
     */
    public function store(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) : User
    {
        //Валидируем
        $date = $this->userValidator->validate($args);


        /**
         * Получаем User по токену
         * @var User
         *
        */
        $user = $this->authService->getUserAuth();

        /** @var CreateUserDTO */
        $createUserDTO = $this->userValidator->createUserDTO($date, $user);

        /** @var User */
        $user = $this->userService->createUser($createUserDTO);

        return $user;
    }

    public function update(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)  : User
    {

        /**
         * Получаем User по токену
         * @var User
         *
        */
        $user = $this->authService->getUserAuth();

        /** @var UpdateUserDTO */
        $updateUserDTO = UpdateUserDTO::make(
            user: User::findOrFail($args['user_id']),
            userOwner: $user,
            role: $args['role'],
            active: $args['active'],
        );

        /** @var User */
        $user = $this->userService->updateUser($updateUserDTO);

        return $user;

    }

    /**
     * Восстановление пароля
     * @param mixed $root
     * @param array $args
     * @param GraphQLContext $context
     * @param ResolveInfo $resolveInfo
     *
     * @return User
     */
    public function resetPassword(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)  : User
    {

        dd(1);

        /**
         * Получаем User по токену
         * @var User
         *
        */
        $user = $this->authService->getUserAuth();

        /** @var UpdateUserDTO */
        $updateUserDTO = UpdateUserDTO::make(
            user: User::findOrFail($args['user_id']),
            userOwner: $user,
            role: $args['role'],
            active: $args['active'],
        );

        /** @var User */
        $user = $this->userService->updateUser($updateUserDTO);

        return $user;

    }

}

