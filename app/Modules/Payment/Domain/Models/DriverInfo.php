<?php

namespace App\Modules\Payment\Domain\Models;

use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\Pivot\Domain\Models\UserOrganization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DriverInfo extends Model
{
    use HasFactory, HasUuids;

    // protected static function newFactory()
    // {
    //     return UserFactory::new();
    // }

    protected $table = 'driver_info_storages';

    protected $fillable = [

        "key",
        "value",
        "payment_method_id",
        "user_organization_id",

    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [

    ];

    public function paymentMethod() : BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'id');
    }

    public function organization()
    {
        return $this->hasOneThrough(
            Organization::class,         // конечная модель
            UserOrganization::class,       // промежуточная модель
            'id',                          // внешний ключ в таблице user_organization, связывающий её с DriverInfo
            'id',                          // внешний ключ в таблице organization, связывающий её с user_organization
            'user_organization_id',        // локальный ключ в таблице driver_info
            'organization_id'              // локальный ключ в таблице user_organization
        );
    }

    public function user()
    {
        return $this->hasOneThrough(
            Organization::class,         // конечная модель
            UserOrganization::class,       // промежуточная модель
            'id',                          // внешний ключ в таблице user_organization, связывающий её с DriverInfo
            'id',                          // внешний ключ в таблице organization, связывающий её с user_organization
            'user_organization_id',        // локальный ключ в таблице driver_info
            'organization_id'              // локальный ключ в таблице user_organization
        );
    }
}
