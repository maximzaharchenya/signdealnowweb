<?php


namespace App\Services;


use App\Mail\GeneralMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailService
{

    public function send(string $to, string $subject, string $content, string $button_text = null, string $button_link = null)
    {
        $message_data['title'] = $subject;
        $message_data['content'] = $content;
        $message_data['button_link'] = $button_link;
        $message_data['button_text'] = $button_text;

        Log::info('Sending email to ' . $to . ', subject: ' . $subject);

        if ((env('APP_ENV') == 'prod') || env('APP_ENV') == 'stage') Mail::to($to)->send(new GeneralMail($message_data));
    }

}
