<?php

namespace App\Modules\User\Domain\Interactor;

use App\Modules\Base\DTO\BaseDTO;
use Illuminate\Support\Facades\DB;
use App\Modules\User\Domain\Models\User;
use App\Modules\Base\Interactor\BaseInteractor;
use App\Modules\Notification\Domain\Models\EmailList;
use App\Modules\Notification\Domain\Models\PhoneList;
use App\Modules\User\App\Data\DTO\Notification\CreateNotificationDTO;
use App\Modules\Notification\Domain\Actions\List\CreateEmailListAction;
use App\Modules\Notification\Domain\Actions\List\CreatePhoneListAction;

class NotificationInteractor extends BaseInteractor
{
    /**
     *
     * @param CreateNotificationDTO $dto
     *
     * @return User
     */
    public function execute(BaseDTO $dto) : User
    {
        return $this->run($dto);
    }

    /**
     * @param CreateNotificationDTO $dto
     *
     * @return User
     */
    protected function run(BaseDTO $dto) : User
    {
        /** @var User */
        $user = DB::transaction(function ($pdo) use ($dto) {

            /** @var User */
            $user = $dto->user;

            if(!is_null($dto->email)) {

                /** @var EmailList */
                $emailList = $this->createEmailList($dto);

                $user->emailList()->associate($emailList);

                $user->save();

            } else {

                /** @var PhoneList */
                $phoneList = $this->createEmailList($dto);

                $user->phonelist()->associate($phoneList);

                $user->save();
            }

            return $user;
        });

        return $user;
    }

    public function createEmailList(CreateNotificationDTO $dto)
    {
        return CreateEmailListAction::make($dto->email, true);
    }

    public function createPhoneList(CreateNotificationDTO $dto)
    {
        return CreatePhoneListAction::make($dto->phone, true);
    }



}
