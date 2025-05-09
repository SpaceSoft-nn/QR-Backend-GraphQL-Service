<?php

namespace App\Modules\Subscription\App\Data\ValueObject;

use Illuminate\Support\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use App\Modules\Base\Traits\FilterArrayTrait;
use App\Modules\Subscription\Domain\Models\SubscriptionPlan;

final readonly class SubscriptionVO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(

        public ?string $plan_name,
        public string $personal_area_id,

        public ?string $subscriptionable_id,
        public ?string $subscriptionable_type,

        public ?int $count_workspace,
        public ?int $payment_limit,

        public ?string $expires_at,

    ) {}



    public static function make(


        string $personal_area_id,

        ?string $subscriptionable_id,
        ?string $subscriptionable_type,

        ?int $count_workspace,
        ?int $payment_limit,

        ?string $expires_at,

        ?string $plan_name = "basic",

    ) : self {

        return new self(

            plan_name: $plan_name,
            personal_area_id: $personal_area_id,
            subscriptionable_id: $subscriptionable_id,
            subscriptionable_type: $subscriptionable_type,
            count_workspace: $count_workspace,
            payment_limit: $payment_limit,
            expires_at: $expires_at,

        );

    }

    public function setPlanName(string $plan_name) : self
    {
        return self::make(
            plan_name: $plan_name,
            personal_area_id: $this->personal_area_id,
            subscriptionable_id: $this->subscriptionable_id,
            subscriptionable_type: $this->subscriptionable_type,
            count_workspace: $this->count_workspace,
            payment_limit: $this->payment_limit,
            expires_at: $this->expires_at,
        );
    }

    public function setExpiresAt(string $expires_at) : self
    {
        return self::make(
            plan_name: $this->plan_name,
            personal_area_id: $this->personal_area_id,
            subscriptionable_id: $this->subscriptionable_id,
            subscriptionable_type: $this->subscriptionable_type,
            count_workspace: $this->count_workspace,
            payment_limit: $this->payment_limit,
            expires_at: $expires_at,
        );
    }

    public function setPolymorph(string $subscriptionable_id, string $subscriptionable_type) : self
    {
        return self::make(
            plan_name: $this->plan_name,
            personal_area_id: $this->personal_area_id,
            subscriptionable_id: $subscriptionable_id,
            subscriptionable_type: $subscriptionable_type,
            count_workspace: $this->count_workspace,
            payment_limit: $this->payment_limit,
            expires_at: $this->expires_at,
        );
    }

    public function setPaymentLimit(int $payment_limit) : self
    {
        return self::make(
            plan_name: $this->plan_name,
            personal_area_id: $this->personal_area_id,
            subscriptionable_id: $this->subscriptionable_id,
            subscriptionable_type: $this->subscriptionable_type,
            count_workspace: $this->count_workspace,
            payment_limit: $payment_limit,
            expires_at: $this->expires_at,
        );
    }

    public function setCountWorkspace(int $countWorkspace) : self
    {
        return self::make(
            plan_name: $this->plan_name,
            personal_area_id: $this->personal_area_id,
            subscriptionable_id: $this->subscriptionable_id,
            subscriptionable_type: $this->subscriptionable_type,
            count_workspace: $countWorkspace,
            payment_limit: $this->payment_limit,
            expires_at: $this->expires_at,
        );
    }

    public function toArray() : array
    {
        return [
            "plan_name" => $this->plan_name,
            "personal_area_id" => $this->personal_area_id,
            "subscriptionable_id" => $this->subscriptionable_id,
            "subscriptionable_type" => $this->subscriptionable_type,
            "count_workspace" => $this->count_workspace,
            "payment_limit" => $this->payment_limit,
            "expires_at" => $this->expires_at,
        ];
    }

    public static function modelForValueObject(SubscriptionPlan $sub) : self
    {

        return self::make(
            personal_area_id: $sub->personal_area_id,
            subscriptionable_id: $sub->subscriptionable_id,
            subscriptionable_type: $sub->subscriptionable_type,
            count_workspace: $sub->count_workspace,
            payment_limit: $sub->payment_limit,
            expires_at: $sub->expires_at,
            plan_name: $sub->plan_name,
        );

    }

}


