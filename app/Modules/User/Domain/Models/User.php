<?php

namespace App\Modules\User\Domain\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use App\Modules\User\App\Data\Enums\UserRoleEnum;
use App\Modules\User\Domain\Factories\UserFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Modules\Notification\Domain\Models\EmailList;
use App\Modules\Notification\Domain\Models\PhoneList;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\PersonalArea\Domain\Models\PersonalArea;
use App\Modules\Workspace\Domain\Models\Workspace;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, HasUuids, Notifiable;

    protected static function newFactory()
    {
        return UserFactory::new();
    }

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

        //для удоности при связи
        'email',
        'phone',

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


    public function getJWTIdentifier()
    {
        return $this->getKey(); // Обычно это идентификатор пользователя. Используйте поле, которое определяет пользователя уникально
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function organizations() : BelongsToMany
    {
        return $this->belongsToMany(Organization::class, 'user_organization', 'user_id', 'organization_id')->withPivot(['id']);
    }

    public function workspaces() : BelongsToMany
    {
        return $this->belongsToMany(Workspace::class, 'user_workspace', 'user_id', 'workspace_id')->withPivot([
            'active_user',
            'is_owner',
            'id'
        ]);
    }

    public function personalAreas() : BelongsToMany
    {
        return $this->belongsToMany(PersonalArea::class, 'user_personal_area', 'user_id', 'personal_area_id');
    }

    public function emailList() : BelongsTo
    {
        return $this->belongsTo(EmailList::class, 'email_id', 'id');
    }

    public function phoneList() : BelongsTo
    {
        return $this->belongsTo(PhoneList::class, 'phone_id', 'id');
    }
}
