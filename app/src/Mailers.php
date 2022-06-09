<?php


namespace app\src;


use app\System;

class Mailers extends System
{

    public static function sending_letter_utf8(

        //  ... For the user
        string $mail_to, $mail_message,

        //  ... Message header
        string $mail_subject = '(No subject)',

        //  ... From the site
        string $from_email = 'no-reply@experimentation.online',
        string $from_username = 'Experimentation Online',

        //  ...
        string $reply_to = 'reply-to@experimentation.online'

    ): bool
    {

        //  ...
        $subject_preferences = array(
            //  ...
            "input-charset"     => self::$encoding,
            "output-charset"    => self::$encoding,
            //  ...
            "line-length"       => 76,
            "line-break-chars"  => '\r\n'
        );

        //  ...
        $from_username = '=?UTF-8?B?' . base64_encode($from_username) . '?=';
        $mail_subject  = '=?UTF-8?B?' . base64_encode($mail_subject)  . '?=';
        
        //  ...
        $headers  = "MIME-Version: 1.0 \r\n";
        $headers .= "Content-type: text/html; charset=" . self::$encoding . " \r\n";
        
        //  ...
        $headers .= "From: " . $from_username . " <" . $from_email . ">" . "\r\n";
        $headers .= "Reply-To: Experimentation Online <no-reply@experimentation.online>" . "\r\n";
        
        //  ...
        $headers .= "Content-Transfer-Encoding: 8bit" . "\r\n";
        $headers .= "Date: " . date("r (T)") . " \r\n"; //  ...
        $headers .= iconv_mime_encode("Subject", $mail_subject, $subject_preferences);

        //  ...
        return mail("<" . $mail_to . ">", $mail_subject, $mail_message, $headers);

    }

}
