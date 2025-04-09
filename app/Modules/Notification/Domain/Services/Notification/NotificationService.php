<?php
namespace App\Modules\Notification\Domain\Services\Notification;

use App\Modules\Notification\App\Data\DTO\Base\BaseDTO;
use App\Modules\Notification\App\Data\DTO\Service\Notification\Confirm\ConfirmDTO;
use App\Modules\Notification\App\Data\DTO\Service\SendNotificationDTO;
use App\Modules\Notification\Domain\Interface\Service\INotification;
use App\Modules\Notification\Domain\Services\NotificationChannel\NotificationChannelService;
use Illuminate\Database\Eloquent\Model;

class NotificationService implements INotification
{
    public function __construct(
        private NotificationChannelService $serviceNotificationChannel,
    ) { }

    /**
     * Проверяем подтвреждён ли email
     * @param string $data
     *
     * @return ?Model
     */
    public function emailConfirmed(string $data) : ?Model
    {
        return $this->serviceNotificationChannel->emailConfirmed($data);
    }

    /**
     * Проверяем подтвреждён ли phone
     * @param string $data
     *
     * @return ?Model
     */
    public function phoneConfirmed(string $data) : ?Model
    {
        return $this->serviceNotificationChannel->phoneConfirmed($data);
    }

    /**
     * Запуск работы нотификации
     * @param SendNotificationDTO $dto
     *
     * @return array
     */
    public function runNotification(BaseDTO $dto) : array
    {
        return $this->serviceNotificationChannel->runNotificationChannel($dto);
    }

    /**
     * Подтверждения кода
     * @param ConfirmDTO $dto
     *
     * @return array возваращает массив сообщение + статус
     */
    public function confirmNotification(BaseDTO $dto) : array
    {
        return $this->serviceNotificationChannel->confirmNotificationChannel($dto);
    }
}
