<?php


namespace app\core;


use app\src\Timeout;
use app\System;

class View extends System
{

    #   ... [%] ~@
    //  ...
    public static string $layout = 'index';

    #   ... [%] ~@
    //  ...
    public static string $content = '';
    //  ...
    public static string $script = '';

    #   ... [%] ~@
    //  ...
    public static function rendering(
        array $vars = array()
    ): void
    {   #   ... code

        //  ...
        if (\count($vars))
        {
            \extract($vars, EXTR_PREFIX_SAME, 'wddx');
        }

        //  ...
        $debug_backtrace = debug_backtrace(2)[1];

        //  ...
        $parser = \explode('/', \trim(\str_replace(
            '\\', DIRECTORY_SEPARATOR, $debug_backtrace['class']
        ), '/'));

        //  ...
        $directory = \str_replace('Controller', '', \end(
            $parser
        ));

        //  ...
        $filename = \mb_strtolower(
            $debug_backtrace['function']
        );

        //  ...
        $folder = 'http/' . \mb_strtolower($directory) . '/content/' . $filename;

        //  ...
        \ob_start();

        //  ...
        if (\file_exists(INC_ROOT . '/' . $folder . '.html'))
        {
            include INC_ROOT . '/' . $folder . '.html';
        }

        //  ...
        $content = \ob_get_clean();

        //  ...
        Timeout::end();

        //  ...
        $timeout_total = Timeout::total();

        //  ...
        if (\file_exists(INC_ROOT . '/http/' . self::$layout . '.html'))
        {
            include INC_ROOT . '/http/' . self::$layout . '.html';
        }

        //  ...
        exit();

    }   #   ... encode

    #   ... [%] ~@
    //  ...
    public static function start()
    {   #   ... code

        #   ...
        \ob_start();

    }   #   ... encode

    #   ... [%] ~@
    //  ...
    public static function end(string $name = 'content')
    {   #   ... code

        //  ...
        if (isset(self::$$name))
        {
            self::$$name = \ob_get_clean();
        }

    }   #   ... encode

}
