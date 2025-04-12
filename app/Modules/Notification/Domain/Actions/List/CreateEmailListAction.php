<?php
namespace App\Modules\Notification\Domain\Actions\List;

use App\Modules\Notification\Domain\Models\EmailList;

class CreateEmailListAction
{

    public static function make(string $email, ?bool $status = null) : EmailList
    {
       return (new self())->run($email, $status);
    }

    public function run(string $email, ?bool $status = null) : EmailList
    {

        $model = EmailList::query()
            ->firstOrCreate(
                [
                    'value' => $email,
                ],
                [$status && 'status' => $status]
            );

        return $model;
    }

}
