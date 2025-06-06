<?php

namespace App\Modules\User\Presentation\HTTP\Graphql\Response;

use App\Modules\User\Domain\Models\User;
use Nuwave\Lighthouse\Execution\ResolveInfo;
use App\Modules\Auth\Domain\Services\AuthService;
use App\Modules\User\Domain\Services\UserService;
use App\Modules\Auth\App\Data\Entity\TokeJwtEntity;
use App\Modules\Notification\Domain\Models\EmailList;
use App\Modules\Notification\Domain\Models\SendEmail;
use App\Modules\User\App\Data\DTO\User\CreateUserDTO;
use App\Modules\User\App\Data\DTO\User\UpdateUserDTO;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Modules\User\App\Data\DTO\User\ResetPasswordDTO;
use App\Modules\User\Domain\Validators\CreateUserValidator;
use App\Modules\User\App\Data\DTO\User\RegistrationСonfirmationDTO;
use App\Modules\Notification\Domain\Services\Notification\NotificationService;
use App\Modules\Notification\App\Data\DTO\Service\Notification\Confirm\ConfirmDTO;

class UserResolver
{

    public function __construct(
        private CreateUserValidator $userValidator,
        private UserService $userService,
        private AuthService $authService,
        private NotificationService $notificationService,
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
     * Восстановление пароля - после проверки кода
     * @param mixed $root
     * @param array $args
     * @param GraphQLContext $context
     * @param ResolveInfo $resolveInfo
     *
     * @return User
     */
    public function resetPassword(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) : array
    {


        #TODO Временно делаем восстановление по почте

        /** @var array */
        $status = $this->notificationService->confirmNotification(ConfirmDTO::make(
            code: $args['code'],
            uuid: $args['uuid_send'],
            type: 'email',
        ));


        //Если возникает какая-либо ошибка - отвечаем на фронт
        if(!$status['status']) { return $status; }

        /** @var User */
        $user = $this->userService->resetPassword(ResetPasswordDTO::make(
            password: $args['password'],
            sendEmail: SendEmail::find($args['uuid_send']),
        ));

        /** @var TokeJwtEntity */
        $auth = $this->authService->loginUser($user);

        return [
            "authToken" => $auth,
            "message" => "Пароль успешно изменён.",
            "status" => true,
        ];
    }

     /**
     * Восстановление пароля - после проверки кода
     * @param mixed $root
     * @param array $args
     * @param GraphQLContext $context
     * @param ResolveInfo $resolveInfo
     *
     * @return User
     */
    public function registrationСonfirmation(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) : array
    {

        /**
         * Возвращаем массив с полями ответа
         * @var array
        */
        $status = $this->notificationService->confirmNotification(ConfirmDTO::make(
            code: $args['code'],
            uuid: $args['uuid_send'],
            type: 'email',
        ));

        //Если возникает какая-либо ошибка - отвечаем на фронт
        if(!$status['status']) { return $status; }

        /** @var User */
        $user = $this->userService->registrationСonfirmation(RegistrationСonfirmationDTO::make(
            sendEmail: SendEmail::find($args['uuid_send']),
        ));

        /** @var TokeJwtEntity */
        $auth = $this->authService->loginUser($user);

        return [
            "authToken" => $auth,
            "message" => "Регистрация успешна завершена.",
            "status" => true,
        ];
    }

}

