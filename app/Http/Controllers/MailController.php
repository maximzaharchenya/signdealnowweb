<?php

namespace App\Http\Controllers;

use App\Services\MailService;

class MailController extends Controller
{

    public function test()
    {

        $message_data['title'] = 'Добро пожаловать на SignDealNow';
        $message_data['content'] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';
//        $message_data['button_link'] = env('APP_URL');
        $message_data['button_link'] = config('app.url');
        $message_data['button_text'] = 'Войти на сайт';
        $message_data['footer'] = 'Спасибо, что вы с нами!';

        $mailService = new MailService();
        $mailService->send('2660117@gmail.com', $message_data['title'], $message_data['content'], $message_data['button_text'], $message_data['button_link'],);

        return response()->json('Done!');
    }

}
