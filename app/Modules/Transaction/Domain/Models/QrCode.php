<?php

namespace App\Modules\Transaction\Domain\Models;

use App\Modules\Base\Money\Money;
use App\Modules\Transaction\App\Data\Enums\QrTypeEnum;
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
        "qr_type",

        "ttl",
        "width",
        "height",

        "content_image_base64",

    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        "amount" => Money::class,
        "qr_type" => QrTypeEnum::class,
    ];

    public function getContentImageBase64Attribute($value)
    {
        if (is_resource($value)) {
            return stream_get_contents($value);
        }
        return $value;
    }


    public function transaction() : BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }
}
