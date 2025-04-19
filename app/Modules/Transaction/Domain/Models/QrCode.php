<?php

namespace App\Modules\Transaction\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QrCode extends Model
{
    use HasFactory, HasUuids;

    // protected static function newFactory()
    // {
    //     return UserFactory::new();
    // }

    protected $table = 'qr_codes';

    protected $fillable = [

        "qr_url",
        "name_product",
        "transaction_id",
        "amount",

    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [

    ];


    public function transaction() : BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }
}
