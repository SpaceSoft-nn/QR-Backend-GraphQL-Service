<?php

namespace App\Modules\Subscription\Domain\Factories;


use App\Modules\Subscription\App\Data\ValueObject\SubscriptionVO;
use App\Modules\Subscription\Domain\Models\SubscriptionPlan;
use Illuminate\Database\Eloquent\Factories\Factory;


class SubscriptionPlanFactory extends Factory
{
    protected $model = SubscriptionPlan::class;

    public function definition(): array
    {
        $subscriptionVO = SubscriptionVO::make();

        return $subscriptionVO->toArrayNotNull();
    }

    public function addAuthActiveByUser(array $user)
    {
        $user['auth'] = true;
        return $user;
    }
}


