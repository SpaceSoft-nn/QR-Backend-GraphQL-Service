<?php

namespace App\Modules\Organizaion\Domain\Models;

use App\Modules\Organizaion\App\Data\Enums\OrganizationTypeEnum;
use App\Modules\User\Domain\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Organizaion extends Model
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
}
