<?php

namespace App\Modules\Payment\Domain\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payment extends Model
{
    use HasFactory, HasUuids;

    // protected static function newFactory()
    // {
    //     return UserFactory::new();
    // }

    protected $table = 'payments';

    protected $fillable = [

        "status",
        "number_uuid",
        "name",
        "driver",

    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [

    ];

    public function driverInfos() : HasMany
    {
        return $this->hasMany(PaymentMethod::class, 'payment_method_id', 'id');
    }
}
