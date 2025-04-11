<?php

namespace App\Modules\User\Presentation\HTTP\Graphql\Response;

use App\Modules\User\App\Data\DTO\User\CreateUserDTO;
use App\Modules\User\Domain\Validators\Default\UserValidator;
use Nuwave\Lighthouse\Execution\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;


class AuthResolver
{

    public function __construct(
        private UserValidator $userValidator,
    ) {}


    public function registration(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) : array
    {
        //Валидируем
        $date = $this->userValidator->validate($args);

        /** @var CreateUserDTO */
        $createUserDTO = $this->userValidator->createUserDTO($date);

        dd($createUserDTO);

        return [];

    }

}

