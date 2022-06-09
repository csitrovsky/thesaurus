<?php


namespace app\src;


use app\System;

class Http extends System
{

    #   ... [%] ~@
    //  ...
    public static function url(): string
    {   #   ... code

        //  ...
        return \trim(\urldecode(\parse_url(
            $_SERVER['REQUEST_URI'], PHP_URL_PATH
        )), '/');

    }   #   ... encode

}
