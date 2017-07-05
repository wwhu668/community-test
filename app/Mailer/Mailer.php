<?php

namespace App\Mailer;

use Naux\Mail\SendCloudTemplate;

class Mailer
{
    protected function sendTo($template, $email, array $data)
    {
        $content = new SendCloudTemplate($template, $data);

        \Mail::raw($content, function ($message) use ($email) {
            $message->from('wuwenhu940226@163.com', 'Laravel');

            $message->to($email);
        });
    }
}