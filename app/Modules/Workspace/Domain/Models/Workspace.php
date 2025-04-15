<?php

namespace App\Modules\Workspace\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\User\Domain\Models\User;
use App\Modules\Payment\Domain\Models\Payment;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Workspace extends Model
{
    use HasFactory, HasUuids;

    // protected static function newFactory()
    // {
    //     return UserFactory::new();
    // }

    protected $table = 'workspaces';

    protected $fillable = [

        "user_organization_id",
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


    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_workspaces', 'workspace_id', 'user_id')->withPivot('active_user');
    }

}
