<?php

namespace App\Modules\Pivot\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOrganization extends Model
{
    use HasFactory;

    // protected static function newFactory()
    // {
    //     return UserFactory::new();
    // }

    protected $table = 'user_organization';

    protected $fillable = [

        "user_id",
        "organization_id",

    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [

    ];

}
