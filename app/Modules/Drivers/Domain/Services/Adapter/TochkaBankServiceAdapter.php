<?php

namespace App\Modules\Drivers\Domain\Services\Adapter;

use App\Modules\Base\DTO\BaseDTO;
use App\Modules\Base\Entity\QrEntityBase;
use App\Modules\Drivers\Domain\Services\TochkaBankService;
use App\Modules\Drivers\App\Data\DTO\CreateQrTochkaBankDTO;
use App\Modules\Drivers\Domain\Interface\Service\IPaymentDriverService;

class TochkaBankServiceAdapter implements IPaymentDriverService
{

    public function __construct(
        private TochkaBankService $service,
        public array $args,
    ) { }

    public static function make(

        TochkaBankService $service,
        array $args

    ) : self {

        return new self(
            service: $service,
            args: $args,
        );

    }

    //Здесь в адаптере мы можем сформировать для каждой платежки свою логику DTO
    public function createQr() : QrEntityBase
    {

        $dto = CreateQrTochkaBankDTO::make(
            amount: $this->args['amount'],
            paymentPurpose: "",
            qrcType: $this->args['qr_type'],

            width: $this->args['width'] ?? null,
            height: $this->args['height'] ?? null,
            sourceName: $this->args['sourceName'] ?? null,
            ttl: $this->args['ttl'] ?? null,
            workspace_id: $this->args['workspace_id'] ?? null,
        );

        $this->service->setСreateQrTochkaBankDTO($dto);

        return $this->service->createQr();
    }
}
