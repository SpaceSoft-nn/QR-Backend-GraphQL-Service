<?php

namespace App\Modules\User\Presentation\HTTP\Graphql\Response;

use App\Modules\User\Domain\Models\User;
use Nuwave\Lighthouse\Execution\ResolveInfo;
use App\Modules\Auth\Domain\Services\AuthService;
use App\Modules\User\Domain\Services\UserService;
use App\Modules\Auth\Domain\Resources\JwtResoruce;
use App\Modules\Auth\App\Data\Entity\TokeJwtEntity;
use App\Modules\User\App\Data\DTO\User\LoginUserDTO;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Modules\User\App\Data\DTO\User\RegistrationUserDTO;
use App\Modules\User\Domain\Validators\RegistrationValidator;


class AuthResolver
{

    public function __construct(
        private RegistrationValidator $userValidator,
        private UserService $userService,
        private AuthService $authService,
    ) { }

    public function registration(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) : array
    {

        //Валидируем
        $date = $this->userValidator->validate($args);

        /** @var RegistrationUserDTO */
        $createUserDTO = $this->userValidator->createUserDTO($date);

        /** @var User */
        $user = $this->userService->registrationUser($createUserDTO);

        /** @var TokeJwtEntity  */
        $tokeJwtEntity = $this->authService->loginUser($user);

        return JwtResoruce::make($tokeJwtEntity)->toArray(request());
    }

    public function login(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) : array
    {

        /** @var User */
        $user = $this->userService->loginUser(LoginUserDTO::make(
            email: $args['email'] ?? null,
            phone: $args['phone'] ?? null,
            password: $args['password'],
        ));

        /** @var TokeJwtEntity  */
        $tokeJwtEntity = $this->authService->loginUser($user);

        return JwtResoruce::make($tokeJwtEntity)->toArray(request());
    }

}

