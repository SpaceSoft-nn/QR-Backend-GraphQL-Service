<?php

namespace App\Modules\Subscription\Domain\Models;

use App\Modules\Base\Money\Money;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\Subscription\Domain\Factories\TariffWorkspaceFactory;

class TariffWorkspace extends Model
{
    use HasFactory, HasUuids;

    protected static function newFactory()
    {
        return TariffWorkspaceFactory::new();
    }

    protected $table = 'tariff_workspaces';

    protected $fillable = [

        "name_tariff",

        "price",
        "price_discount",

        "discount",

        "count_workspace",
        "description",
        "period",

    ];

    protected $guarded = [
        'id',
        "number_id",
        'created_at',
        'updated_at',
    ];

    protected $hidden = [

    ];

    protected $casts = [
        "price" => Money::class,
        "price_discount" => Money::class,
    ];

    public function subscription(): MorphMany
    {
        return $this->morphMany(SubscriptionPlan::class, 'subscriptionable');
    }

}
