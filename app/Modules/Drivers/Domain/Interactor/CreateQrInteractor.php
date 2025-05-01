<?php

namespace App\Modules\Drivers\Domain\Interactor;

use function App\Helpers\Mylog;
use App\Modules\Base\DTO\BaseDTO;
use Illuminate\Support\Facades\Http;
use App\Modules\Base\Interactor\BaseInteractor;
use App\Modules\Drivers\App\Data\DTO\CreateQrDTO;
use App\Modules\Workspace\Domain\Models\Workspace;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\Drivers\App\Data\Entities\TochkaBankEntity;
use App\Modules\Drivers\Domain\Exceptions\TochkaBank\QrBusinessException;
use App\Modules\Drivers\Common\Config\TochkaBank\TochkaBankQrCreateConfig;

class CreateQrInteractor extends BaseInteractor
{
    const URL = "https://enter.tochka.com/sandbox/v2/sbp/v1.0/qr-code/merchant/MF0000000001/40817810802000000008/044525104";

    public function __construct(
        private TochkaBankQrCreateConfig $conf
    ) { }


    /**
     * @param CreateQrDTO $dto
     *
     * @return TochkaBankEntity
     */
    public function execute(BaseDTO $dto) : TochkaBankEntity
    {
        return $this->run($dto);
    }


    /**
     * @param CreateQrDTO $dto
     *
     * @return TochkaBankEntity
     */
    protected function run(BaseDTO $dto) : TochkaBankEntity
    {

        /** @var Workspace */
        $workspace = $this->findWorkspace($dto->workspace_id);

        //формируем правильное назначение платежа
        $this->formingValidDTO($dto, $workspace);

        //базовый запрос для создании QR spb у точки
        $data = [
            "Data" => [
                "paymentPurpose" => $dto->paymentPurpose,
                "qrcType" => $dto->qrcType->isNumber(),
                "amount" => $dto->amount ?? $this->conf->amount->value_kopeck,
                "currency" => $this->conf->currency,
                "imageParams" => [
                    "width" => $dto->width ?? $this->conf->imageParams['width'],
                    "height" => $dto->height ?? $this->conf->imageParams['height'],
                    "mediaType" => $this->conf->imageParams['mediaType'],
                ],
                "sourceName" => $dto->sourceName ?? $this->conf->sourceName,
                "ttl" => $dto->ttl ?? $this->conf->ttl,
            ]
        ];

        $response = Http::asJson()->withToken('working_token')
            ->post(static::URL, $data);


        if ($response->successful()) {

            $jsonBody = $response->body();

            /** @var array */
            $array = json_decode($jsonBody, true);

            return TochkaBankEntity::fromArrayToObject($array);

        } else {

            $jsonBody = $response->getBody();
            $formatted = $this->formatErrorMessageFromJson($jsonBody);

            Mylog('Ошибка формирование QR СБП, точка апи: ' . $formatted, 'qr');
            throw new QrBusinessException("Ошибка формирование QR СБП.", 500);
        }

    }

    //для форматироование ошибки
    private function formatErrorMessageFromJson($jsonBody) {
        $data = json_decode($jsonBody, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return 'Ошибка декодирования JSON: ' . json_last_error_msg();
        }

        $lines = [];

        if (isset($data['code'])) {
            $lines[] = "Код ошибки: " . $data['code'];
        }
        if (isset($data['id'])) {
            $lines[] = "ID запроса: " . $data['id'];
        }
        if (isset($data['message'])) {
            $lines[] = "Сообщение: " . $data['message'];
        }
        if (!empty($data['Errors'])) {
            $lines[] = "Ошибки:";
            foreach ($data['Errors'] as $index => $error) {
                $errStr = "  #".($index+1).": ";
                if (isset($error['errorCode'])) {
                    $errStr .= $error['errorCode'] . " - ";
                }
                if (isset($error['message'])) {
                    $errStr .= $error['message'];
                }
                if (isset($error['url'])) {
                    $errStr .= " [Документация](" . $error['url'] . ")";
                }
                $lines[] = $errStr;
            }
        }

        return implode(PHP_EOL, $lines);
    }

    /**
    * Формируем валидный ДТО, указываем описание: paymentPurpose
    * @return [type]
    */
    private function formingValidDTO(CreateQrDTO $dto, Workspace $workspace) : CreateQrDTO
    {
        /** @var Organization */
        $organization = $workspace->organization;

        $data = now()->locale('ru')->isoFormat('DD MMMM YYYY, HH:mm');

        $dto->paymentPurpose = "Оплата от $data , по (АРМ №:$workspace->id), у организации ($organization->name)";

        return $dto;
    }

    private function findWorkspace(string $workspace_id) : Workspace
    {
        return Workspace::findOrFail($workspace_id);
    }

}
