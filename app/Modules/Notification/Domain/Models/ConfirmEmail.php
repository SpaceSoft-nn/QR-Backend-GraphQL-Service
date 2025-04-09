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
 * @property-read \App\Modules\Notification\Domain\Models\SendEmail|null $send
 * @method static \Illuminate\Database\Eloquent\Builder|ConfirmEmail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfirmEmail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfirmEmail query()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfirmEmail whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfirmEmail whereConfirm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfirmEmail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfirmEmail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfirmEmail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfirmEmail whereUuidSend($value)
 * @mixin \Eloquent
 */
class ConfirmEmail extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'confirm_email_notification';

    protected $fillable = [
        'uuid_send',
        'code',
        'confirm',
    ];

    public function send(): BelongsTo
    {
        return $this->belongsTo(SendEmail::class,'uuid_send', 'id');
    }

}
