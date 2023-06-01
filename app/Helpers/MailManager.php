<?php
/**
 * Created by PhpStorm.
 * User: klajdi
 * Date: 18-04-19
 * Time: 11.00.PD
 */

namespace App\Helpers;


use Illuminate\Support\Facades\Mail;


/**
 * Class MailManager
 * @package App\Helpers
 */

class MailManager
{
    /**
     * @param $from
     * @param $subject
     * @param $receivers
     * @param $content
     * @param null $attachments
     *
     *
     * Use in controller
     * $attach = public_path(Storage::url("docs/20180413115839_Resume.pdf")); just for testing, if you want to send email from storage
     * MailManager::sendEmail("test@test.com", "hi klajdi", ["klajdidp@gmail.com", "klajdisharka1994@gmail.com"], "ckemi", $attach);
     */
    public static function sendEmail($from, $subject, $receivers, $content, $attachments = null){
       
        Mail::send([], [], function ($message) use ($from, $receivers, $subject, $content, $attachments) {
            $message->from('info@landmark.al')->to($receivers)->subject($subject)->setBody($content, 'text/html');

            if(isset($attachments) && count($attachments) > 0 && $attachments !== null){
                foreach ($attachments as $attach){
                    $message->attach($attach);
                }
            }
        });
    }

}