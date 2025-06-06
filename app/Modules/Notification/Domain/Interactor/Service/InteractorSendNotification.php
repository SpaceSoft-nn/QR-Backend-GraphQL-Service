<?php
namespace App\Modules\Notification\Domain\Interactor\Service;

use Illuminate\Support\Facades\DB;
use App\Modules\Notification\Domain\Models\EmailList;
use App\Modules\Notification\Domain\Models\PhoneList;
use App\Modules\Notification\Domain\Models\SendEmail;
use App\Modules\Notification\Domain\Models\SendPhone;
use App\Modules\Notification\App\Data\DTO\Service\SendNotificationDTO;
use App\Modules\Notification\App\Data\DTO\Service\CreateSendAction\CreateSendDTO;
use App\Modules\Notification\App\Repositories\Notification\Send\SendEmailRepository;
use App\Modules\Notification\App\Repositories\Notification\Send\SendPhoneRepository;
use App\Modules\Notification\Domain\Actions\SendAndConfirm\Send\CreateSendEmailAction;
use App\Modules\Notification\Domain\Actions\SendAndConfirm\Send\CreateSendPhoneAction;

class InteractorSendNotification
{

    public function __construct(
        private SendEmailRepository $repositoryEmail,
        private SendPhoneRepository $repositoryPhone,
    ) { }


    /**
     * Метод проверки на возможность отправки кода email
     * @param string $uuid
     *
     * @return bool - true отправка кода доступна
     */
    private function not_block_send_email(string $uuid) : bool
    {
        return $this->repositoryEmail->not_block_send($uuid);
    }

    /**
    * Метод проверки на возможность отправки кода phone
    * @param string $uuid
    *
    * @return bool - true отправка кода доступна
    */
    private function not_block_send_phone(string $uuid) : bool
    {
        return $this->repositoryPhone->not_block_send($uuid);
    }

    /**
     * Создание/поиск записи в таблицах email и проверка на уникальность
     * P.S - Изменили только на поиск записи
     *
     * @param string $data
     *
     * @return ?EmailList
     */
    private function EntityNotifyEmail(string $data) : ?EmailList
    {
        /** @var ?EmailList */
        $model = EntityNotificationEmailInteractor::make($data);

        return $model;
    }

    /**
    * Создание записи в таблицах phone и проверка на уникальность
    * @return [type]
    */
    private function EntityNotifyPhone(string $data) : ?PhoneList
    {
        return EntityNotificationPhoneInteractor::make($data);
    }

    /**
     * Создание записи в таблице send_email_notification
     * @param CreateSendDTO $data
     *
     * @return ?SendEmail
     */
    private function CreateSendEmail(CreateSendDTO $data) : ?SendEmail
    {
        return CreateSendEmailAction::make($data);
    }

    /**
     * Создание записи в таблице send_phone_notification
     * @param CreateSendDTO $data
     *
     * @return ?SendPhone
     */
    private function CreateSendPhone(CreateSendDTO $data) : ?SendPhone
    {
        return CreateSendPhoneAction::make($data);
    }

    private function arrayResponse(bool $status , ?string $uuid = null, ?int $code = null) : array
    {
        //лучше в будущем сделать DTO
        return [
            'uuid' => $uuid,
            'status' => $status,
            'code' => $code
            #TODO В идеале тут присылать время сколько подождать человеку перед отправкой.
        ];
    }

    public function runSendEmail(SendNotificationDTO $dto) : array
    {
        //можно сделать через hanlder
        return DB::transaction(function ($connect) use ($dto) {
            $driver = $dto->driver->value;

            //Поиска list
            /** @var ?EmaiList */
            $model = $this->EntityNotifyEmail($dto->value);

            //проверяем может ли пользователь повторно отправить код
            if($this->not_block_send_email($model->id))
            {
                //создание кода для отправки (send table)
                $model = $this->CreateSendEmail(CreateSendDTO::make(
                    value: $model->value,
                    driver: $driver,
                    uuid: $model->id,
                ));


                return $this->arrayResponse(true, $model->id, $model->code);
            }

            return $this->arrayResponse(false);
        });
    }

    public function runSendPhone(SendNotificationDTO $dto) : array
    {
        //можно сделать через hanlder
        return DB::transaction(function ($connect) use ($dto)  {
            $driver = $dto->driver->value;

            $model = $this->EntityNotifyPhone($dto->value);

            //проверяем на возможность отправки кода
            if($this->not_block_send_phone($model->id))
            {
                //создание кода для отправки (send table)
                $model = $this->CreateSendPhone(CreateSendDTO::make(
                    value: $model->value,
                    driver: $driver,
                    uuid: $model->id,
                ));

                return $this->arrayResponse(true, $model->id, $model->code);
            }

            return $this->arrayResponse(false);
        });

    }

}
