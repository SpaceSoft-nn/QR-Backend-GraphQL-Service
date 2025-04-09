<?php

namespace App\Modules\Transaction\Domain\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\Transaction\App\Data\Enums\StatusTransactionEnum;
use App\Modules\Workspace\Domain\Models\Workspace;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        "qr_code_id",

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
            $model->number_uuid = (string) Str::uuid(); // Генерируем UUID при создании модели
        });
    }

    public function qrCode() : HasOne
    {
        return $this->hasOne(QrCode::class, 'qr_code_id', 'id');
    }

    public function workspace() : BelongsTo
    {
        return $this->belongsTo(Workspace::class, 'workspace_id', 'id');
    }
}
