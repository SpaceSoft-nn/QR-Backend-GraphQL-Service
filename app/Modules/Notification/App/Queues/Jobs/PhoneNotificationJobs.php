<?php
namespace App\Modules\Notification\App\Queues\Jobs;

use App\Modules\Notification\App\Data\DTO\AeroDTO;
use App\Modules\Notification\App\Data\DTO\Config\AeroConfigDTO;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class PhoneNotificationJobs implements ShouldQueue
{
    use Queueable;

    use SerializesModels; //при получении модели в job, он не сохраняет всю модель, а хранит в бд только ссылку на модель, и потом сериализует её.

    private AeroDTO $dto;
    private AeroConfigDTO $config;
    /**
     * Create a new job instance.
     */
    public function __construct(
        AeroDTO $dto
    ) {
        $this->config = new AeroConfigDTO(
            email: env('AERO_SMS_EMAIL'),
            apiKey: env('AERO_SMS_APIKEY'),
        );

        $this->dto = $dto;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->driverLogicAero();
    }

    private function driverLogicAero()
    {
        $smsAeroMessage = new \SmsAero\SmsAeroMessage($this->config->email, $this->config->apiKey);

        $response = $smsAeroMessage->send([
            'number' => $this->dto->phone,
            'text' => "Ваш код подтверждения: {$this->dto->code}",
            'sign' => $this->config->sign
        ]);

        if(!$response) {
            Log::info('Ошибка отправки смс сообщение через AeroDriver ' . now() . "---->" . __DIR__);
        }

    }
}
