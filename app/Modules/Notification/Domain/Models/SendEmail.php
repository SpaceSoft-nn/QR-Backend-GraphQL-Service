<?php

namespace App\Modules\Notification\Domain\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * 
 *
 * @property string $id
 * @property string $uuid_list
 * @property string $driver Драйвер отправки
 * @property string $value Почта
 * @property int $code Код для подтверждения активации
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SendEmail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SendEmail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SendEmail query()
 * @method static \Illuminate\Database\Eloquent\Builder|SendEmail whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SendEmail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SendEmail whereDriver($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SendEmail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SendEmail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SendEmail whereUuidList($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SendEmail whereValue($value)
 * @mixin \Eloquent
 */
class SendEmail extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'send_email_notification';

    protected $fillable = ['uuid_list', 'value', 'driver', 'code', 'created_at'];

    /**
     * @return HasMany
     */
    public function confirms(): HasMany
    {
        return $this->hasMany(ConfirmEmail::class)->chaperone();
    }

}
