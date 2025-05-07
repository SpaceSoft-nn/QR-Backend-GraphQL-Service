<?php

namespace App\Modules\Subscription\Domain\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class TariffWorkspace extends Model
{
    use HasFactory, HasUuids;

    // protected static function newFactory()
    // {
    //     return SubscriptionPlanFactory::new();
    // }

    protected $table = 'tariff_workspaces';

    protected $fillable = [

        "number_id",
        "name_tariff",
        "price",
        "count_workspace",
        "discount",
        "description",
        "period",

    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [

    ];

    protected $casts = [
        // "price" => Money::class,
    ];

    public function subscription(): MorphMany
    {
        return $this->morphMany(SubscriptionPlan::class, 'subscriptionable');
    }

}
