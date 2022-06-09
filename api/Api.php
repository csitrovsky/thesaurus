<?php


namespace api;


use app\src\Customers;
use app\System;

abstract class Api extends Customers
{

    #   ... [%] ~@
    //  ...
    protected static string $method;

    #   ... [%] ~@
    //  ...
    public function __construct()
    {   #   ... code

        //  ...
        self::$method = $_SERVER['REQUEST_METHOD'];

    }   #   ... encode

    #   ... [%] ~@
    //  ...
    public static function engine(
        string $class
    )
    {   #   ... code

        //  ...
        $function = self::get_function_name();

        //  ...
        if (\method_exists($class, $function))
        {
            return $class::$function();
        }

        //  ...
        throw new \RuntimeException(
            'Invalid Method', 405
        );

    }   #   ... encode

    #   ... [%] ~@
    //  ...
    protected static function response(
        $data = array(), int $code = 500
    )
    {   #   ... code

        //  ...
        header('HTTP/1.1 ' . $code . ' ' . self::request_status($code));

        //  ...
        try {
            return \json_encode($data, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            return false;
        }


    }   #   ... encode

    #   ... [%] ~@
    //  ...
    protected static function get_function_name(): ?string
    {   #   ... code

        //  ...
        if ($_SERVER['REQUEST_METHOD'] === 'GET')
        {
            return 'get';
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            return 'POST';
        }

        if ($_SERVER['REQUEST_METHOD'] === 'PUT')
        {
            return 'PUT';
        }

        if ($_SERVER['REQUEST_METHOD'] === 'DELETE')
        {
            return 'delete';
        }

        //  ...
        return null;

    }   #   ... encode

    #   ... [%] ~@
    //  ...
    private static function request_status(
        int $code
    ): string
    {   #   ... code

        //  ...
        if (\array_key_exists($code, System::$http_status_codes))
        {
            return System::$http_status_codes[$code];
        }
        System::$http_status_codes[500];

    }   #   ... encode

    #   ... [%] ~@
    //  ...
    abstract protected static function get();

    #   ... [%] ~@
    //  ...
    abstract protected static function post();

    #   ... [%] ~@
    //  ...
    abstract protected static function put();

    #   ... [%] ~@
    //  ...
    abstract protected static function delete();

}
