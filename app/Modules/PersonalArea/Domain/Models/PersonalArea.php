<?php

namespace App\Modules\PersonalArea\Domain\Models;

use App\Modules\Base\Money\Money;
use Illuminate\Database\Eloquent\Model;
use App\Modules\User\Domain\Models\User;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Modules\Subscription\Domain\Models\SubscriptionPlan;
use App\Modules\PersonalArea\Domain\Factories\PersonalAreaFactory;
use App\Modules\PersonalArea\Domain\Observers\PersonalAreaObserver;

#[ObservedBy([PersonalAreaObserver::class])]
class PersonalArea extends Model
{
    use HasFactory, HasUuids;

    protected static function newFactory()
    {
        return PersonalAreaFactory::new();
    }

    protected $table = 'personal_areas';

    protected $fillable = [

        "owner_id",
        "subscription_id",
        "balance",

    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [

    ];

    protected $casts = [
        "balance" => Money::class,
    ];

    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_personal_area', 'personal_area_id', 'user_id');
    }

    public function owner() : BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    public function subscription() : HasOne
    {
        return $this->hasOne(SubscriptionPlan::class, 'personal_area_id', 'id');
    }

    public function balanceLogs() : HasMany
    {
        return $this->hasMany(BalanceLog::class, 'personal_area_id', 'id');
    }

}
