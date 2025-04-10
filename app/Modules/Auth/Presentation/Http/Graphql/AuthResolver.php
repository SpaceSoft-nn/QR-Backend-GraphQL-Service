<?php

namespace App\Modules\Auth\Presentation\Http\Graphql;

use Illuminate\Database\Eloquent\Model;
use App\Modules\User\Domain\Models\User;
use Nuwave\Lighthouse\Execution\ResolveInfo;
use App\Modules\Auth\App\Data\DTO\UserAttemptDTO;
use App\Modules\Auth\Domain\Services\AuthService;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;



class AuthResolver
{

    public function __construct(
        public AuthService $authService
    ) {}


    /**
     * Возвращать jwt токен если мы нашли юзера.
     *
     * @return array
    */
    public function login(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) : array
    {

        /** @var TokeJwtEntity */
        $entity = $this->authService->attemptUserAuth(
            UserAttemptDTO::make(
                password: $args['password'],
                phone: $args['phone'] ?? null,
                email: $args['email'] ?? null,
                payload: null,
            )
        );

        return $entity->toArray();

    }

    /**
     * Возвращать user по полученному токену в bearer.
     * @return User
     */
    public function user(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) : ?Model
    {
        return $this->authService->getUserAuth();
    }

    /**
     * Удалить актуальный токен.
     *
     * @return string
     */
    public function logout(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) : string
    {
        $status = $this->authService->logout();

        return $status
            ? "You have successfully logged out."
            : "Logout error.";
    }

    /**
     * Инвалидировать акутальные токены Access и Refresh и вернуть новый.
     *
     * @return array
     */
    public function refresh(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) : array
    {
        return ($this->authService->refresh())->toArray();
    }


    /**
     * Переформировываем токен, устанавливаем полезную нагрузку
     *
     * @return array
     */
    public function setPayload(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) : array
    {

        return ($this->authService->setPayload($args))->toArray();

    }



}

