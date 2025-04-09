<?php

namespace App\Modules\Notification\Domain\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property string $id
 * @property string $uuid_list
 * @property string $driver Драйвер отправки
 * @property string $value Номер телефона
 * @property int $code Код для подтверждения активации
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SendPhone newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SendPhone newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SendPhone query()
 * @method static \Illuminate\Database\Eloquent\Builder|SendPhone whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SendPhone whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SendPhone whereDriver($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SendPhone whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SendPhone whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SendPhone whereUuidList($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SendPhone whereValue($value)
 * @mixin \Eloquent
 */
class SendPhone extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'send_phone_notification';

    protected $fillable = ['uuid_list' ,'value', 'driver', 'code' , 'created_at'];
}
