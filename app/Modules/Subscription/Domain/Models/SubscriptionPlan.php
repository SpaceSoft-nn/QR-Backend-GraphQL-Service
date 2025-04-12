<?php

namespace App\Modules\Subscription\Domain\Models;

use App\Modules\Base\Money\Money;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\PersonalArea\Domain\Models\PersonalArea;
use App\Modules\Subscription\Domain\Factories\SubscriptionPlanFactory;

class SubscriptionPlan extends Model
{
    use HasFactory, HasUuids;

    protected static function newFactory()
    {
        return SubscriptionPlanFactory::new();
    }

    protected $table = 'subscriptions';

    protected $fillable = [

        "plan_name",
        "price",
        "expires_at",

    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [

    ];

    protected $casts = [
        "price" => Money::class,
    ];

    public function PersonalAreas() : HasMany
    {
        return $this->HasMany(PersonalArea::class, 'subscription_id', 'id');
    }
}
