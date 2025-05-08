<?php

namespace App\Modules\Subscription\App\Data\Policies;

use Illuminate\Auth\Access\Response;
use App\Modules\User\Domain\Models\User;
use App\Modules\Subscription\Domain\Models\SubscriptionPlan;

class SubscriptionPolicy
{


    // /**
    //  * Имеет ли подписка тариф
    //  * @param User $userOwner
    //  * @param User $user
    //  *
    //  * @return bool
    //  */
    // public function subscriptionHasPolicy(User $user, SubscriptionPlan $sub) : Response
    // {
    //     $model = $sub->subscriptionable;

    //     return $model ?Response::deny('You do not own this post.') : Response::deny('You do not own this post.');
    // }


}
