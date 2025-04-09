<?php

namespace App\Modules\Notification\Domain\Services\NotificationChannel;

use App\Modules\Notification\App\Data\DTO\Base\BaseDTO;
use App\Modules\Notification\App\Data\DTO\Service\Notification\Confirm\ConfirmDTO;
use App\Modules\Notification\App\Data\DTO\Service\SendNotificationDTO;
use App\Modules\Notification\App\Repositories\Notification\List\EmailList\EmailListRepository;
use App\Modules\Notification\App\Repositories\Notification\List\PhoneList\PhoneListRepository;
use App\Modules\Notification\Domain\Interactor\Service\ConfirmCode\InteractorConfirmNotification;
use App\Modules\Notification\Domain\Interactor\Service\InteractorSendNotification;
use App\Modules\Notification\Domain\Interface\Service\INotificationChannel;
use App\Modules\Notification\Domain\Services\NotificationSend\NotificationSendService;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NotificationChannelService implements INotificationChannel
{

    public function __construct(
        private NotificationSendService $serviceNotification,
        private InteractorConfirmNotification $interactorConfirm,
        private EmailListRepository $emailRep,
        private PhoneListRepository $phoneRep,
    ) { }

    public function emailConfirmed(string $data) : ?Model
    {
        return $this->emailRep->getByEmailStatusTrue($data);
    }

    public function phoneConfirmed(string $data) : ?Model
    {
        return $this->phoneRep->getByPhoneStatusTrue($data);
    }


     /**
     * Объединение логики создание записи email + создания/отправки кода
     * @param SendNotificationDTO $dto
     *
     * @return array
     */
    private function InteractorSendEmail(SendNotificationDTO $dto) : array
    {
        /** @var array */
        $array = DB::transaction(function () use ($dto) {

            //объединение логики создание записей в интерактор send+list table
            $interactor = app(InteractorSendNotification::class);
            $status = $interactor->runSendEmail($dto);

            if($status['status'])
            {
                $dto = SendNotificationDTO::make($dto->driver->value, $dto->value, $status['code']);

                $this->serviceNotification->sendNotification($dto);

                return [
                    'uuid_send' => $status['uuid'],
                    'message' => 'Отправка была успешна.',
                    'status' => true,
                ];


            }



            return [
                'message' => 'Повторная отправка возможна через несколько минут.',
                'status' => false,
            ];
        });

        return $array;

    }

    /**
     * Объединение логики создание записи phone + создания/отправки кода
     * @param SendNotificationDTO $dto
     *
     * @return array
     */
    private function InteractorSendPhone(SendNotificationDTO $dto) : array
    {
        /** @var array */
        $array = DB::transaction(function () use ($dto) {
            //объединение логики создание записей в интерактор send+list table
            $interactor = app(InteractorSendNotification::class);
            $status = $interactor->runSendPhone($dto);

            if($status['status'])
            {
                $dto = SendNotificationDTO::make($dto->driver->value, $dto->value, $status['code']);

                $this->serviceNotification->sendNotification($dto);
                return [
                    'uuid_send' => $status['uuid'],
                    'message' => 'Отправка была успешна.',
                    'status' => true,
                ];
            }

            return [
                'message' => 'Повторная отправка возможна через несколько минут.',
                'status' => false,
            ];

        });

        return $array;

    }


    /**
     * Метод интерактор для объединение бизнес логики для отправки нотификации
     * @return [type]
     */
    private function InteractorSendNotification(SendNotificationDTO $dto) : array
    {
        $driver = $dto->driver->value;

        switch($driver)
        {
            case 'smtp' :
            {
                return $this->InteractorSendEmail($dto);
            }

            case 'aero' :
            {
                return $this->InteractorSendPhone($dto);
            }

            default:
            {
                Log::info("Неизвестный драйвер нотификации при вызове [sendNotification]");
                throw new Exception('Неизвестный драйвер нотификации', 500);
            }
        }

    }


    /**
     * Запуск работы нотификации по каналам (SMTP/SMS)
     * @param SendNotificationDTO $dto
     *
     * @return array
    */
    public function runNotificationChannel(BaseDTO $dto) : array
    {
        return $this->InteractorSendNotification($dto);
    }

    /**
     * Запуск работы подтверждения кода
     * @param ConfirmDTO $dto
     *
     * @return array
    */
    public function confirmNotificationChannel(BaseDTO $dto) : array
    {
        return $this->interactorConfirm->confirmCode($dto);
    }

}
