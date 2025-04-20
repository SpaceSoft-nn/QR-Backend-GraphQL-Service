<?php

namespace App\Modules\Payment\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\Payment\Domain\Factories\PaymentMethodFactory;


class PaymentMethod extends Model
{
    use HasFactory, HasUuids;

    protected static function newFactory()
    {
        return PaymentMethodFactory::new();
    }

    protected $table = 'payment_methods';

    protected $fillable = [

        "active",
        "driver_name",
        "payment_id",

    ];

    protected $guarded = [
        'id',
        'number_id',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [

    ];

    public function driverInfos() : HasMany
    {
        return $this->hasMany(DriverInfo::class, 'payment_method_id', 'id');
    }

    public function payment() : BelongsTo
    {
        return $this->belongsTo(Payment::class, 'payment_id', 'id');
    }


}
