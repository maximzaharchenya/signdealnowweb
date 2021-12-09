<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GeneralMail extends Mailable
{
    use Queueable, SerializesModels;

    public $message_data;

    public function __construct($message_data)
    {
        $this->message_data = $message_data;
    }

    public function build()
    {
        return $this->subject(!empty($this->message_data['title']) ? $this->message_data['title'] : 'SignDealNow')->view('mail.general');
    }
}
