<?php

namespace App\Modules\Pivot\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPersonalArea extends Model
{
    use HasFactory;

    // protected static function newFactory()
    // {
    //     return UserFactory::new();
    // }

    protected $table = 'user_personal_area';

    protected $fillable = [

        "user_id",
        "personal_area_id",

    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [

    ];

}
