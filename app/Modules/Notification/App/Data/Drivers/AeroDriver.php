<?php
namespace App\Modules\Notification\App\Data\Drivers;

use App\Modules\Notification\App\Data\Drivers\Base\BaseDriver;
use App\Modules\Notification\App\Data\DTO\AeroDTO;
use App\Modules\Notification\App\Data\DTO\Base\BaseDTO;
use App\Modules\Notification\App\Queues\Jobs\PhoneNotificationJobs;
use App\Modules\Notification\Domain\Interface\NotificationDriverInterface;

class AeroDriver extends BaseDriver implements NotificationDriverInterface
{

    /**
    * @param AeroDTO $dto
    */
    public function send(BaseDTO $dto) : void
    {
        if ($dto instanceof AeroDTO) {
            dispatch(new PhoneNotificationJobs($dto));
        } else {
            throw new \InvalidArgumentException("Invalid DTO type");
        }
    }

    public function getNameString() : string
    {
        return "aero";
    }

}
