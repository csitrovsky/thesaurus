<?php


namespace app\core;


use app\src\Errors;

abstract class Controller
{

    #   ... [%] ~@
    protected static array $params;

    #   ... [%] ~@
    //  ...
    public function __construct(
        array $params
    )
    {   #   ... code

        //  ...
        self::$params = $params;

    }   #   ... encode

    #   ... [%] ~@
    //  ...
    protected static function model()
    {   #   ... code

        //  ...
        $debug_backtrace = debug_backtrace(2)[1];

        //  ...
        $parser = \explode('/', \trim(\str_replace(
            '\\', DIRECTORY_SEPARATOR, $debug_backtrace['class']
        ), '/'));

        //  ...
        $class_name = \str_replace('Controller', '', \end(
                $parser
        ));

        //  ...
        $class = 'http\\' . \mb_strtolower($class_name) . '\\' . $class_name . 'Model';

        //  ...
        if (\class_exists($class))
        {
            return new $class();
        }

        //  ...
        Errors::output($code = 403,
            'The module was not loaded'
        );

        //  ...
        exit();

    }   #   ... encode

}
