<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public $from_user;
    public $to_user;
    public $body;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $from_user, User $to_user, $body)
    {
        $this->from_user = $from_user;
        $this->to_user = $to_user;
        $this->body = $body;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.mail');
    }
}
