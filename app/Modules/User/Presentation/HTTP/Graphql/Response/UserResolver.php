<?php

namespace App\Modules\User\Presentation\HTTP\Graphql\Response;

use App\Modules\User\Domain\Models\User;
use Nuwave\Lighthouse\Execution\ResolveInfo;
use App\Modules\Auth\Domain\Services\AuthService;
use App\Modules\User\Domain\Services\UserService;
use App\Modules\User\App\Data\DTO\User\CreateUserDTO;
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

}

