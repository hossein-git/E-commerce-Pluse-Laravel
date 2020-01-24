<?php

namespace App\Jobs;

use App\Mail\PaymentMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;

class SendOrderEmailsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var string
     */
    private $email;
    /**
     * @var array
     */
    private $data;

    /**
     * Create a new job instance.
     *
     * @param string $email
     * @param array $data
     */
    public function __construct(string $email, array $data)
    {
        $this->email = $email;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            sleep(50);
            Mail::to($this->email)->send(new PaymentMail($this->data));
        } catch (Exception $e) {
            Log::channel('jobs')->error('message: ' . $e->getMessage()
                . "\r\n" . 'Code:' . $e->getCode());
        }

    }

    /**
     * Log the failed jobs
     */
    public function failed()
    {
        Log::channel('jobs')->alert(
            'could not send email order to ' . $this->email . "\r\n"
            . 'data: ' . implode(',', $this->data)
        );
    }
}
