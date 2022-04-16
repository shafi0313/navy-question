<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $forgetData;
    public function __construct($forgetData)
    {
        $this->forgetData = $forgetData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Reset Password')
            ->html(
                (new MailMessage)
                ->mailer('noReply')
                ->line('Click the Reset Password button to set a new password')
                ->action('Reset Password', route('resetPassword', $this->forgetData->token))
                ->line('Thank you for using our application!')
                ->render()
            );
    }
}
