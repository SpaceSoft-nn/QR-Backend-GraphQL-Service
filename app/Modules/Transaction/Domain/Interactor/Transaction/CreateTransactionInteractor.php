<?php

namespace App\Modules\Transaction\Domain\Interactor\Transaction;

use App\Modules\Base\DTO\BaseDTO;
use Illuminate\Support\Facades\DB;
use App\Modules\Base\Entity\QrEntityBase;
use App\Modules\Base\Interactor\BaseInteractor;
use App\Modules\Transaction\Domain\Models\QrCode;
use App\Modules\Transaction\Domain\Models\Transaction;
use App\Modules\Transaction\App\Data\DTO\TransactionDTO;
use App\Modules\Transaction\App\Data\ValueObject\QrCodeVO;
use App\Modules\Transaction\Domain\Actions\CreateQrCodeAction;
use App\Modules\Transaction\App\Data\ValueObject\TransactionVO;
use App\Modules\Transaction\Domain\Actions\CreateTransactionAction;
use App\Modules\Drivers\Domain\Interface\Service\IPaymentDriverService;

class CreateTransactionInteractor extends BaseInteractor
{

    private IPaymentDriverService $service;

    public function __construct(
        IPaymentDriverService $service,
    ) {
        $this->service = $service;
    }

    /**
     *
     * @param TransactionDTO $dto
     *
     * @return Transaction
     */
    public function execute(BaseDTO $dto) : Transaction
    {
        return $this->run($dto);
    }

    /**
     * @param TransactionDTO $dto
     *
     * @return Transaction
     */
    protected function run(BaseDTO $dto) : Transaction
    {

        /**
         * Получаем сформированный ответ от апи (Здесь будет вызываться Сервис в зависимости от Фабричного Метода Transaction)
         * @var QrEntityBase
         *
        */
        $entity = $this->service->createQr();


        /** @var Transaction */
        $model = DB::transaction(function ($pdo) use ($dto, $entity) {

            /** @var TransactionVO */
            $transactionVO = $dto->transactionVO;

            /** @var Transaction */
            $transaction = $this->createTransaction($transactionVO);

            /**
             * Временно создаём qrCode - тут будет запрос к платежному шлюзу для формирование qr кода
             * @var QrCode
             *
            */
            $qrCode = $this->createQrCode(
                QrCodeVO::make(
                    transaction_id: $transaction->id,
                    qr_url: $entity->payload,
                    qr_type: $entity->qrcType->value,

                    ttl: $entity->ttl,
                    width: $entity->width,
                    height: $entity->height,

                    name_product: $transaction->name_product,
                    amount: $transactionVO->amount,
                    content_image_base64: $entity->content_image_base64,
                )
            );

            return $transaction;
        });

        return $model;
    }



    private function createQrCode(QrCodeVO $vo) : QrCode
    {
        return CreateQrCodeAction::make($vo);
    }

    private function createTransaction(TransactionVO $vo) : Transaction
    {
        return CreateTransactionAction::make($vo);
    }

}
