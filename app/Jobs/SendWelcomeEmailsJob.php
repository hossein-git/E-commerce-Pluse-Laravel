<?php

namespace App\Jobs;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;

class SendWelcomeEmailsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var User
     */
    private $user;

    /**
     * Create a new job instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            sleep(20);
            Mail::send(['html' => 'emails.welcome'],
                ['name' => $this->user->name], function (Message $message) {
                    $message->to("$this->user->email", "$this->user->name")->subject('welcome');
                });
        } catch (Exception $exception) {
            Log::channel('jobs')->error('message: ' . $exception->getMessage()
                . "\r\n" . 'Code:' . $exception->getCode());
        }

    }

    /**
     * log the failed job
     */
    public function failed()
    {
        Log::channel('jobs')->alert(' send welcome  message to ' . $this->user->name . ' failed');
    }
}
