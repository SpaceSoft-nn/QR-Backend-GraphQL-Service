<?php

namespace App\Modules\User\Presentation\HTTP\Graphql\Response;

use App\Modules\User\Domain\Models\User;
use Nuwave\Lighthouse\Execution\ResolveInfo;
use App\Modules\Auth\Domain\Services\AuthService;
use App\Modules\User\Domain\Services\UserService;
use App\Modules\Auth\App\Data\Entity\TokeJwtEntity;
use App\Modules\User\App\Data\DTO\User\CreateUserDTO;
use App\Modules\User\Domain\Validators\UserValidator;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;


class AuthResolver
{

    public function __construct(
        private UserValidator $userValidator,
        private UserService $userService,
        private AuthService $authService,
    ) {}

    public function registration(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) : array
    {
        //Валидируем
        $date = $this->userValidator->validate($args);

        /** @var CreateUserDTO */
        $createUserDTO = $this->userValidator->createUserDTO($date);

        /** @var User */
        $user = $this->userService->registrationUser($createUserDTO);

        /** @var TokeJwtEntity  */
        $tokeJwtEntity  = $this->authService->loginUser($user);

        return $tokeJwtEntity->toArray();
    }

}

