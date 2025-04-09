<?php

namespace App\Modules\Notification\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $key
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigNotification whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigNotification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigNotification whereValue($value)
 * @mixin \Eloquent
 */
class ConfigNotification extends Model
{
    use HasFactory;

    protected $table = 'config_notification';

    protected $fillable = [
        'key',
        'value',
    ];

}
