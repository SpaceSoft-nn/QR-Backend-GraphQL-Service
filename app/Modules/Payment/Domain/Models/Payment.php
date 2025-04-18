<?php

namespace App\Modules\Payment\Domain\Models;

use App\Modules\Payment\Domain\Factories\PaymentFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payment extends Model
{
    use HasFactory, HasUuids;

    protected static function newFactory()
    {
        return PaymentFactory::new();
    }

    protected $table = 'payments';

    protected $fillable = [

        "status",
        "name",

    ];

    protected $guarded = [
        'id',
        "number_id",
        'created_at',
        'updated_at',
    ];




    protected $hidden = [

    ];

    public function driverInfos() : HasMany
    {
        return $this->hasMany(PaymentMethod::class, 'payment_method_id', 'id');
    }

    public function paymentMethods() : HasMany
    {
        return $this->hasMany(PaymentMethod::class, 'payment_id', 'id');
    }
}
