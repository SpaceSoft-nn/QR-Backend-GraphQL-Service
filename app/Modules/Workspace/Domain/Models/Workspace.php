<?php

namespace App\Modules\Workspace\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\User\Domain\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Modules\Payment\Domain\Models\PaymentMethod;
use App\Modules\Transaction\Domain\Models\Transaction;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Modules\Workspace\Domain\Factories\WorkspaceFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Workspace extends Model
{
    use HasFactory, HasUuids;

    protected static function newFactory()
    {
        return WorkspaceFactory::new();
    }

    protected $table = 'workspaces';

    protected $fillable = [

        "user_organization_id",
        "name",
        "description",
        "is_active",
        "payment_method_id",

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

    public function transactions() : HasMany
    {
        return $this->hasMany(Transaction::class, 'workspace_id', 'id');
    }

    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_workspace', 'workspace_id', 'user_id')->withPivot([
            'active_user',
            'is_owner',
        ]);
    }

}
