<?php

namespace App\Modules\Drivers\Domain\Interface\Service;

use App\Modules\Base\DTO\BaseDTO;
use App\Modules\Base\Entity\QrEntityBase;

/**
 * Общий интерфейс для сервисов оплат: Тинькофф, Сбербанк, Точка банк и т.д
 */
interface IPaymentDriverService
{
    public function createQr() : QrEntityBase; //Создание qr coda СБП
}
