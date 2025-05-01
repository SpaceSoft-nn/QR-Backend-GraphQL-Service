<?php

namespace App\Modules\Transaction\Domain\Interactor\Transaction;

use App\Modules\Base\DTO\BaseDTO;
use Illuminate\Support\Facades\DB;
use App\Modules\Base\Entity\QrEntityBase;
use App\Modules\Base\Interactor\BaseInteractor;
use App\Modules\Transaction\Domain\Models\QrCode;
use App\Modules\Workspace\Domain\Models\Workspace;
use App\Modules\Transaction\Domain\Models\Transaction;
use App\Modules\Transaction\App\Data\DTO\TransactionDTO;
use App\Modules\Drivers\Domain\Services\TochkaBankService;
use App\Modules\Transaction\App\Data\ValueObject\QrCodeVO;
use App\Modules\Transaction\Domain\Actions\CreateQrCodeAction;
use App\Modules\Transaction\App\Data\ValueObject\TransactionVO;
use App\Modules\Transaction\Domain\Actions\CreateTransactionAction;

class CreateTransactionInteractor extends BaseInteractor
{

    public function __construct(
        private TochkaBankService $service,
    ) { }


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
        /** @var BaseDTO */
        $dtoQr = $dto->dtoQr;

        /**
         * Получаем сформированный ответ от апи
         * @var QrEntityBase
         *
        */
        $entity = $this->service->createQr($dto->dtoQr);

        /** @var Transaction */
        $model = DB::transaction(function ($pdo) use ($dto, $dtoQr, $entity) {

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
                    qr_type: $dtoQr->qrcType->value,

                    ttl: $dtoQr->ttl,
                    width: $dtoQr->width,
                    height: $dtoQr->height,

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
