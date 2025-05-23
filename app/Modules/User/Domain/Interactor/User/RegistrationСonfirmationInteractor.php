<?php

namespace App\Modules\User\Domain\Interactor\User;

use App\Modules\Base\DTO\BaseDTO;
use Illuminate\Support\Facades\DB;
use App\Modules\User\Domain\Models\User;
use App\Modules\Base\Interactor\BaseInteractor;
use App\Modules\Notification\Domain\Models\EmailList;
use App\Modules\User\App\Data\DTO\User\RegistrationСonfirmationDTO;

class RegistrationСonfirmationInteractor extends BaseInteractor
{

    public function __construct(

    ) { }


    /**
     * @param RegistrationСonfirmationDTO $dto
     *
     * @return User
     */
    public function execute(BaseDTO $dto) : User
    {
        return $this->run($dto);
    }


    /**
     * @param RegistrationСonfirmationDTO $dto
     *
     * @return User
     */
    protected function run(BaseDTO $dto) : User
    {

        /** @var User */
        $user = DB::transaction(function ($pdo) use ($dto) {

            /** @var EmailList */
            $emailList = $dto->sendEmail->emailList;

            $emailList->status = true;

            //сохраняем изменение в модели ORM - в базу
            $emailList->save();

            return $emailList->user;
        });

        return $user;
    }

}
