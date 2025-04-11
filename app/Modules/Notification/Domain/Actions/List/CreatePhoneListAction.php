<?php
namespace App\Modules\Notification\Domain\Actions\List;

use App\Modules\Notification\Domain\Models\PhoneList;

class CreatePhoneListAction
{

    public static function make(string $phone, ?bool $status = null) : ?PhoneList
    {
       return (new self())->run($phone);
    }

    public function run(string $phone, ?bool $status = null) : ?PhoneList
    {

        $model = PhoneList::query()
            ->firstOrCreate(
                [
                    'value' => $phone,
                    $status && 'status' => $status
                ],
                ['value' => $phone]
            );

        return $model;
    }

}
