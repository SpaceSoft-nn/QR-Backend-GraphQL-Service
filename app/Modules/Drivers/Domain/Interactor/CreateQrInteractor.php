<?php

namespace App\Modules\Drivers\Domain\Interactor;

use function App\Helpers\Mylog;
use App\Modules\Base\DTO\BaseDTO;
use Illuminate\Support\Facades\Http;
use App\Modules\Base\Interactor\BaseInteractor;
use App\Modules\Drivers\App\Data\Entities\TochkaBankEntity;
use App\Modules\Drivers\Domain\Exceptions\TochkaBank\QrBusinessException;
use App\Modules\Drivers\Common\Config\TochkaBank\TochkaBankQrCreateConfig;

class CreateQrInteractor extends BaseInteractor
{
    const URL = "https://enter.tochka.com/sandbox/v2/sbp/v1.0/qr-code/merchant/MF0000000001/40817810802000000008/044525104";

    public function __construct(
        private TochkaBankQrCreateConfig $conf
    ) { }


    public function execute(BaseDTO $dto) : TochkaBankEntity
    {
        return $this->run($dto);
    }


    protected function run(BaseDTO $dto) : TochkaBankEntity
    {
        //базовый запрос для создании QR spb у точки
        $data = [
            "Data" => [
                "paymentPurpose" => "Оплата по счету № 1 от 01.01.2021. Без НДС",
                "qrcType" => "01",
                "amount" => $this->conf->amount->value_kopeck,
                "currency" => $this->conf->currency,
                "imageParams" => [
                    "width" => $this->conf->imageParams['width'],
                    "height" => $this->conf->imageParams['height'],
                    "mediaType" => $this->conf->imageParams['mediaType'],
                ],
                "sourceName" => $this->conf->sourceName,
                "ttl" => $this->conf->ttl,
            ]
        ];

        $response = Http::asJson()->withToken('working_token')
            ->post(static::URL, $data);

        if ($response->successful()) {

            $jsonBody = $response->body();

            /** @var array */
            $array = json_decode($jsonBody, true);

            dd(TochkaBankEntity::fromArrayToObject($array));

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

}
