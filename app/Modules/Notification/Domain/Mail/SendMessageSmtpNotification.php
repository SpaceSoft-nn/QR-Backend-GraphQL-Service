<?php
namespace App\Modules\Notification\Domain\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendMessageSmtpNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;

    }

    public function build()
    {
        // $viewPath = base_path('app\Modules\Notification\Common\View\Mail\email_code.blade.php');

        return $this->subject('Subject of the email')
            ->view('email_code') // Используйте только название файла без расширения и пути
            ->with([
                'message' => $this->data,
            ]);

        Log::info($status);
    }
}
