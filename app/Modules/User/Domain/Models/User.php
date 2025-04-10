<?php

namespace App\Modules\User\Domain\Models;

use App\Modules\Notification\Domain\Models\EmailList;
use App\Modules\Notification\Domain\Models\PhoneList;
use App\Modules\Organization\Domain\Models\Organization;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Modules\User\App\Data\Enums\UserRoleEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Modules\PersonalArea\Domain\Models\PersonalArea;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Model
{
    use HasFactory, HasUuids, Notifiable;

    // protected static function newFactory()
    // {
    //     return UserFactory::new();
    // }

    protected $table = 'users';

    protected $fillable = [

        'first_name',
        'last_name',
        'father_name',
        'password',

        'role',
        'permission',

        'active',
        'auth',

        'personal_area_id',
        'email_id',
        'phone_id',

    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'access_type',
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'role' => UserRoleEnum::class,
            'password' => 'hashed',
        ];
    }

    public function organizations() : BelongsToMany
    {
        return $this->belongsToMany(Organization::class, 'user_organization', 'user_id', 'organization_id');
    }

    public function personalAreas() : BelongsToMany
    {
        return $this->belongsToMany(PersonalArea::class, 'user_personal_area', 'user_id', 'personal_area_id');
    }

    public function email() : BelongsTo
    {
        return $this->belongsTo(EmailList::class, 'email_id', 'id');
    }

    public function phone() : BelongsTo
    {
        return $this->belongsTo(PhoneList::class, 'phone_id', 'id');
    }
}
