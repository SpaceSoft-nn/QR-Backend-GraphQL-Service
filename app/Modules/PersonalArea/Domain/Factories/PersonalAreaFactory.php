<?php

namespace App\Modules\PersonalArea\Domain\Factories;

use App\Modules\PersonalArea\App\Data\ValueObject\PersonalAreaVO;
use App\Modules\PersonalArea\Domain\Models\PersonalArea;
use App\Modules\Subscription\Domain\Models\SubscriptionPlan;
use App\Modules\User\Domain\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class PersonalAreaFactory extends Factory
{
    protected $model = PersonalArea::class;

    public function definition(): array
    {

        /** @var User */
        $user = User::factory()->create();

        /** @var Subscription */
        $subscription = SubscriptionPlan::factory()->create();

        $personalAreaVO = PersonalAreaVO::make(
            subscription_id: $subscription->id,
            owner_id: $user->id,
            balance: 0,
        );

        return $personalAreaVO->toArrayNotNull();
    }

}

