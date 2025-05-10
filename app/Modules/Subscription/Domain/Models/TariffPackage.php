<?php

namespace App\Modules\Subscription\Domain\Models;

use App\Modules\Base\Money\Money;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\Subscription\Domain\Factories\TariffPackageFactory;

class TariffPackage extends Model
{
    use HasFactory, HasUuids;

    protected static function newFactory()
    {
        return TariffPackageFactory::new();
    }

    protected $table = 'tariff_packages';

    protected $fillable = [


        "name_tariff",
        "price",
        "payment_limit",
        "description",
        "period",

    ];

    protected $guarded = [
        "number_id",
        'id',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [

    ];

    protected $casts = [
        "price" => Money::class,
        // "period" => MonthTariffEnum::class,
    ];

    public function subscription(): MorphMany
    {
        return $this->morphMany(SubscriptionPlan::class, 'subscriptionable');
    }

}
