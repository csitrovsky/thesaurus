<?php


namespace app\src;


class Timeout
{

    #   ... [%] ~@
    //  ...
    private static $time_start;
    private static $time_end;

    #   ... [%] ~@
    //  ...
    private static function time()
    {   #   ... code

        //  ...
        $time = explode(' ', microtime());
        $time = $time[1] + $time[0];

        //  ...
        return $time;

    }   #   ... encode

    #   ... [%] ~@
    //  ...
    public static function start(): void
    {   #   ... code

        //  ...
        $time = self::time();
        self::$time_start = $time;

    }   #   ... encode

    #   ... [%] ~@
    //  ...
    public static function end(): void
    {   #   ... code

        //  ...
        $time = self::time();
        self::$time_end = $time;

    }   #   ... encode

    #   ... [%] ~@
    //  ...
    public static function total()
    {   #   ... code

        //  ...
        return (self::$time_end - self::$time_start);

    }   #   ... encode

}
