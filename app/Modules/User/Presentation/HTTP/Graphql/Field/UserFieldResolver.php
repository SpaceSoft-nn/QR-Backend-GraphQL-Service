<?php

namespace App\Modules\User\Presentation\HTTP\Graphql\Field;

use App\Modules\User\Domain\Models\User;
use Nuwave\Lighthouse\Execution\ResolveInfo;
use App\Modules\User\App\Repositories\UserRepository;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class UserFieldResolver
{

    protected UserRepository $userRepository;

    // Внедряем репозиторий через конструктор
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function email(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) : ?string
    {
        /** @var User */
        $user = $root;

        return $this->userRepository->email($user);
    }

    public function phone(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) : ?string
    {
        $user = $root;

        return $this->userRepository->phone($user);
    }
}
