<?php

namespace App\Modules\Subscription\Domain\Factories;

use App\Modules\PersonalArea\Domain\Models\PersonalArea;
use App\Modules\Subscription\App\Data\ValueObject\SubscriptionVO;
use App\Modules\Subscription\Domain\Models\SubscriptionPlan;
use Illuminate\Database\Eloquent\Factories\Factory;


class SubscriptionPlanFactory extends Factory
{
    protected $model = SubscriptionPlan::class;

    public function definition(): array
    {
        $subscriptionVO = SubscriptionVO::make(
            plan_name: null,
            subscriptionable_id: null,
            subscriptionable_type: null,
            count_workspace: null,
            payment_limit: null,
            expires_at: null,
            personal_area_id: PersonalArea::first(),
        );

        return $subscriptionVO->toArrayNotNull();
    }

}


