<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Account activation')
            ->html(
                (new MailMessage)
                    ->mailer('noReply')
                    ->line('Mr/Mrs'.$this->user->name)
                    ->line('Click the active button to activate your account')
                    ->action('Active', route('registerVerify', $this->user->remember_token))
                    ->line('Thank you for using our application!')
                    ->render()
            );
    }
}
