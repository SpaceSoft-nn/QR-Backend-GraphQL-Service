<?php

namespace App\Modules\Notification\Domain\Actions\SendAndConfirm\Confirm;

use App\Modules\Notification\Domain\Models\ConfirmEmail;

class CreateConfirmEmailAction
{
    public static function make(int $code, string $uuid) : ConfirmEmail
    {
       return (new self())->run($code, $uuid);
    }

    public function run(int $code, string $uuid) : ConfirmEmail
    {

        $model = ConfirmEmail::query()
            ->create(
                [
                    'code' => $code,
                    'uuid_send' => $uuid,
                ],
            );

        return $model;
    }
}
