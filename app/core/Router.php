<?php


namespace app\core;


use app\src\Errors;
use app\src\Http;
use app\System;
use http\home\HomeController;

class Router extends System
{

    #   ... [%] ~@
    //  ...
    public static function set(
        string $route, $function
    )
    {   #   ... code

        //  ...
        self::$routes_mapping[] = $route;

        //  ...
        if ((string)$route === (string)Http::url())
        {
            $function->__invoke();
        }

    }   #   ... encode

    #   ... [%] ~@
    //  ...
    public static function engine(): void
    {   #   ... code

        //  ...
        $url_processing = array(
            'class' => HomeController::class,
            'function' => 'index'
        );

        //  ...
        if (\strlen(Http::url()) > 0 && Http::url() !== '')
        {
            $url_processing = explode(
                '/', Http::url()
            );
        }

        //  ...
        $class = HomeController::class;

        //  ...
        if (\array_key_exists(0, $url_processing))
        {
            $class_name = \array_shift($url_processing);
            $class = 'http\\' . $class_name . '\\' . ucfirst($class_name) . 'Controller';
        }

        //  ...
        if (!\class_exists($class))
        {
            Errors::output($code = '404',
                'Oops! Sorry, page not found'
            );
            exit();
        }

        //  ...
        $function = 'index';

        //  ...
        if (\array_key_exists(0, $url_processing))
        {
            $function = \array_shift($url_processing);
        }

        //  ...
        if (!\method_exists($class, $function))
        {
            Errors::output($code = '404',
                'Oops! Sorry, page not found'
            );
            exit();
        }

        //  ...
        $class = new $class(array(
            'class' => $class,
            'function' => $function
        ));

        //  ...
        $params = array();

        //  ...
        if (\count($url_processing))
        {
            $params = \array_values(
                $url_processing
            );
        }

        //  ...
        if (\call_user_func_array(array(
            $class, $function
        ), $params))
        {
            Errors::output($code = 403,
                'Oops! The page is not available'
            );
            exit();
        }

        //  ...
        exit();

    }   #   ... encode

}
