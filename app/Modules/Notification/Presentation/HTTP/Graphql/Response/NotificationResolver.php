<?php

namespace App\Modules\Notification\Presentation\HTTP\Graphql\Response;

use App\Modules\User\Domain\Models\User;
use Nuwave\Lighthouse\Execution\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Modules\Notification\App\Data\DTO\Service\SendNotificationDTO;
use App\Modules\Notification\Domain\Services\Notification\NotificationService;


class NotificationResolver
{

    public function __construct(
        private NotificationService $notificationService,
    ) {}


    /**
     * Отправляем код нотификации на почту
     * @param mixed $root
     * @param array $args
     * @param GraphQLContext $context
     * @param ResolveInfo $resolveInfo
     *
     * @return User
     */
    public function sendNotification(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) : array
    {

        #TODO делаем временно нотификацию пока что по email

        /** @var array */
        $status = $this->notificationService->runNotification(SendNotificationDTO::make(
            driver: 'smtp',
            value: $args['email'],
        ));


        return $status;

    }

}

