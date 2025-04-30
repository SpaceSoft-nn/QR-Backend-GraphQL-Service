<?php

namespace App\Modules\Drivers\Domain\Interactor;

use App\Modules\Base\DTO\BaseDTO;
use App\Modules\Base\Error\GraphQLBusinessException;
use Illuminate\Support\Facades\Http;
use App\Modules\Base\Interactor\BaseInteractor;

class CreateQrInteractor extends BaseInteractor
{
    const URL = "https://enter.tochka.com/sandbox/v2/sbp/v1.0/qr-code/merchant/MF0000000001/40817810802000000008/044525104";

    public function __construct(

    ) { }


    public function execute(BaseDTO $dto)
    {
        return $this->run($dto);
    }


    protected function run(BaseDTO $dto)
    {

        $data = [
            "Data" => [
                "paymentPurpose" => "Оплата по счету № 1 от 01.01.2021. Без НДС",
                "qrcType" => "01",
                "amount" => 0,
                "currency" => "RUB",
                "imageParams" => [
                    "width" => 200,
                    "height" => 200,
                    "mediaType" => "image/png"
                ],
                "sourceName" => "string",
                "ttl" => 0
            ]
        ];

        $response = Http::asJson()->withToken('working_token')
            ->post(static::URL, $data);

        if ($response->successful()) {
            // Получение данных в виде массива
            $data = $response->json();

            dd($data);

            // Обработка данных
        } else {
            throw new GraphQLBusinessException();
        }

    }

}
