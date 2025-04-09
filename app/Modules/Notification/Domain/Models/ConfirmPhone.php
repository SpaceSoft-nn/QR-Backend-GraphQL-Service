<?php

namespace App\Modules\Notification\Domain\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 
 *
 * @property string $id
 * @property string $uuid_send
 * @property int $code Введённый код пользователем
 * @property bool|null $confirm Статус подтрвеждения кода
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modules\Notification\Domain\Models\SendPhone|null $send
 * @method static \Illuminate\Database\Eloquent\Builder|ConfirmPhone newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfirmPhone newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfirmPhone query()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfirmPhone whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfirmPhone whereConfirm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfirmPhone whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfirmPhone whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfirmPhone whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfirmPhone whereUuidSend($value)
 * @mixin \Eloquent
 */
class ConfirmPhone extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'confirm_phone_notification';

    protected $fillable = [
        'uuid_send',
        'code',
        'confirm',
    ];

    public function send(): BelongsTo
    {
        return $this->belongsTo(SendPhone::class, 'uuid_send', 'id');
    }
}
