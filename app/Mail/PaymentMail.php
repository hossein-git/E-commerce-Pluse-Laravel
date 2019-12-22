<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $payment_email;

    /**
     * Create a new message instance.
     *
     * @param $payment_email array : ['track' => TRACK_CODE, 'payment_status' => '']
     * @return void
     */
    public function __construct(array $payment_email)
    {
        $this->payment_email = $payment_email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.payment');
    }
}
