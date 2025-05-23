<?php
namespace App\Modules\Notification\App\Queues\Jobs;

use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Modules\Notification\App\Data\DTO\SmtpDTO;
use App\Modules\Notification\Domain\Exceptions\Mail\ExceptionSendEmail;
use App\Modules\Notification\Domain\Mail\SendMessageSmtpNotification;

use function App\Helpers\Mylog;

class EmailNotificationJobs implements ShouldQueue
{
    use Queueable;

    use SerializesModels; //при получении модели в job, он не сохраняет всю модель, а хранит в бд только ссылку на модель, и потом сериализует её.

    private string $email;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private SmtpDTO $dto
    ) {
        $this->email = $dto->email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {

            // Отправка уведомления
            Mail::to($this->email)->send(new SendMessageSmtpNotification($this->dto->code));

        } catch (\Throwable $th) {

            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new ExceptionSendEmail('Ошибка в классе: ' . $nameClass, 500);

        }



    }
}
