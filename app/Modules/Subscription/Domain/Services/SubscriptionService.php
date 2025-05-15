<?php

namespace App\Modules\Subscription\Domain\Services;

use App\Modules\Subscription\Domain\Models\SubscriptionPlan;
use App\Modules\Subscription\Domain\Interface\Service\ISubscriptionService;

class SubscriptionService implements ISubscriptionService
{

    public function __construct(

    ) { }

    /**
     * Уменьшаем значение workspace_count у SubscriptionPlan на 1
     * @return bool
     */
    public function decrementWorkspaceCount(SubscriptionPlan $sub) : bool
    {

        if($sub->count_workspace < 0) { return false; }

        $sub->count_workspace = $sub->count_workspace - 1;

        return $sub->save();
    }

    /**
     * Увеличиваем значение workspace_count у SubscriptionPlan на 1
     * @return bool
     */
    public function incrementWorkspaceCount(SubscriptionPlan $sub) : bool
    {

        $sub->count_workspace = $sub->count_workspace + 1;

        return $sub->save();
    }

}


