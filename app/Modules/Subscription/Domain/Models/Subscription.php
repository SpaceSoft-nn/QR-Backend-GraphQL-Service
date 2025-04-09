<?php

namespace App\Modules\Subscription\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\PersonalArea\Domain\Models\PersonalArea;

class Subscription extends Model
{
    use HasFactory, HasUuids;

    // protected static function newFactory()
    // {
    //     return UserFactory::new();
    // }

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

    public function PersonalAreas() : HasMany
    {
        return $this->HasMany(PersonalArea::class, 'subscription_id', 'id');
    }
}
