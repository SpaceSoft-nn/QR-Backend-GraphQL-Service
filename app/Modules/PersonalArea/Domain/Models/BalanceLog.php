<?php

namespace App\Modules\PersonalArea\Domain\Models;

use App\Modules\Base\Money\Money;
use App\Modules\PersonalArea\App\Data\Enums\OperationBalanceEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BalanceLog extends Model
{
    use HasFactory, HasUuids;

    // protected static function newFactory()
    // {
    //     return UserFactory::new();
    // }

    protected $table = 'balance_logs';

    protected $fillable = [

        "personal_area_id",
        "balance_before",
        "balance_after",
        "amount",
        "operation",

    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [

    ];

    protected $casts = [
        "balance_before" => Money::class,
        "balance_after" => Money::class,
        "amount" => Money::class,
        "operation" => OperationBalanceEnum::class,
    ];

    public function personalArea() : BelongsTo
    {
        return $this->belongsTo(PersonalArea::class, 'personal_area_id', 'id');
    }

}
