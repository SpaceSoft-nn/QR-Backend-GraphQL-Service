<?php

namespace App\Modules\Organization\Domain\Models;

use App\Modules\Organization\App\Data\Enums\OrganizationTypeEnum;
use Illuminate\Database\Eloquent\Model;
use App\Modules\User\Domain\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Organization extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'organizations';

    // protected static function newFactory()
    // {
    //     return OrganizationFactory::new();
    // }

    protected $fillable = [

        'owner_id',

        'name',
        'address',
        'website',
        'description',
        'okved',
        'founded_date',

        'phone',
        'email',
        'remuved',
        'type',

        'inn',
        'kpp',
        'registration_number',

    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'type' => OrganizationTypeEnum::class,
            'founded_date' => 'datetime',
        ];
    }

    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_organization', 'organization_id', 'user_id');
    }

    public function owner() : BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }
}
