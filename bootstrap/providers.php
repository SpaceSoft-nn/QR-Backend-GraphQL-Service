<?php


return [
    App\Providers\AppServiceProvider::class,
    App\Modules\Auth\App\Providers\AuthServiceProvider::class,

    App\Modules\Organization\App\Providers\OrganizationServiceProvider::class,
    App\Modules\Subscription\App\Providers\SubscriptionServiceProvider::class,
    App\Modules\Workspace\App\Providers\WorkspaceServiceProvider::class,
    App\Modules\User\App\Providers\UserServiceProvider::class,
    App\Modules\Pivot\App\Providers\PivotServiceProvider::class,
    App\Modules\PersonalArea\App\Providers\PersonalAreaServiceProvider::class,
    App\Modules\Notification\App\Providers\Notification\NotificationServiceProvider::class,
    App\Modules\Payment\App\Providers\PaymentServiceProvider::class,
];
