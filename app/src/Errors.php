<?php


namespace app\src;


use app\System;

class Errors extends System
{

    #   ... [%] ~@
    //  ...
    public static function output(
        int $code, string $message = ''
    ): void
    {   #   ... code

        //  ...
        \http_response_code($response_code = $code);
        die('<pre>customer@error % [' . $code . ':' . self::$http_status_codes[$code] . '] ~@ ' . $message . '...</pre>');

    }   #   ... encode

}
