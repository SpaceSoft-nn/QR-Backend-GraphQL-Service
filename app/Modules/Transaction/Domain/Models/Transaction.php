<?php

namespace App\Modules\Transaction\Domain\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Workspace\Domain\Models\Workspace;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Modules\Payment\Domain\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use App\Modules\Transaction\App\Data\Enums\StatusTransactionEnum;

class Transaction extends Model
{
    use HasFactory, HasUuids;

    // protected static function newFactory()
    // {
    //     return UserFactory::new();
    // }

    protected $table = 'transactions';

    protected $fillable = [

        "status",
        "amount",

        "workspace_id",

        "type_product",
        "count_product",
        "name_product",

    ];

    protected $guarded = [
        'id',
        'number_uuid',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [

    ];

    protected $cast = [
        'status' => StatusTransactionEnum::class,
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->number_uuid = $model->newUniqueId(); // Генерируем UUID при создании модели
        });
    }

    public function qrCode() : HasOne
    {
        return $this->hasOne(QrCode::class, 'transaction_id', 'id');
    }

    public function workspace() : BelongsTo
    {
        return $this->belongsTo(Workspace::class, 'workspace_id', 'id');
    }

    public function paymentMethod() : BelongsTo
    {
        return $this->workspace->paymentMethod();
    }
}
