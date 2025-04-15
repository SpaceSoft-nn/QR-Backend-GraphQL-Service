<?php

namespace App\Modules\Workspace\Presentation\HTTP\Graphql\Response;

use App\Modules\User\Domain\Models\User;
use Nuwave\Lighthouse\Execution\ResolveInfo;
use App\Modules\Auth\Domain\Services\AuthService;
use App\Modules\User\Domain\Services\UserService;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Modules\User\Domain\Validators\CreateUserValidator;
use App\Modules\Workspace\Domain\Models\Workspace;

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
    public function store(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) : Workspace
    {
        return new Workspace();
    }

}

