<?php

namespace App\Modules\Workspace\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Payment\Domain\Models\Payment;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Workspace extends Model
{
    use HasFactory, HasUuids;

    // protected static function newFactory()
    // {
    //     return UserFactory::new();
    // }

    protected $table = 'workspaces';

    protected $fillable = [

        "organizaion_id",
        "name",
        "description",
        "is_active",
        "payment_id",

    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [

    ];

    public function payment() : BelongsTo
    {
        return $this->belongsTo(Payment::class, 'payment_id', 'id');
    }

}
