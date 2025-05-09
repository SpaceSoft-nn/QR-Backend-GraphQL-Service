<?php

namespace App\Modules\Subscription\Domain\Models;

use App\Modules\Base\Casts\RuDateTimeCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\PersonalArea\Domain\Models\PersonalArea;
use App\Modules\Subscription\Domain\Factories\SubscriptionPlanFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

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
        "personal_area_id",

        "subscriptionable_id",
        "subscriptionable_type",

        "count_workspace",
        "payment_limit",

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
        "expires_at" => RuDateTimeCast::class,
    ];

    public function personalArea() : BelongsTo
    {
        return $this->belongsTo(PersonalArea::class, 'personal_area_id', 'id');
    }

    public function subscriptionable(): MorphTo
    {
        return $this->morphTo();
    }
}
