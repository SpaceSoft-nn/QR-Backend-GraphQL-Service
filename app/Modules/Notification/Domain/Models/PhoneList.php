<?php

namespace App\Modules\Notification\Domain\Models;

use App\Modules\Notification\Domain\Factories\PhoneFactory;
use App\Modules\User\Domain\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property string $id
 * @property string $value Номер телефона
 * @property bool $status Статус активации
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PhoneList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PhoneList newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PhoneList query()
 * @method static \Illuminate\Database\Eloquent\Builder|PhoneList whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhoneList whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhoneList whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhoneList whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhoneList whereValue($value)
 * @mixin \Eloquent
 */
class PhoneList extends Model
{
    use HasFactory, HasUuids;

    protected static function newFactory()
    {
        return PhoneFactory::new();
    }

    protected $table = 'phone_list';

    protected $fillable = ['value', 'status'];


    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'phone_id');
    }

}
