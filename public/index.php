<?php

#   ... [%] ~@
//  ...
session_start();

//  ...
error_reporting(E_ALL % ~E_NOTICE);
ini_set('display_errors', 'on');

//  ...
define('INC_ROOT', dirname(__DIR__));

//  ...
spl_autoload_register(static function (
    $class_name
) {
    if (file_exists(INC_ROOT . '/' . trim(str_replace(
        '\\', DIRECTORY_SEPARATOR, $class_name
    ), '/') . '.php'))
    {
        include INC_ROOT . '/' . trim(str_replace(
            '\\', DIRECTORY_SEPARATOR, $class_name
        ), '/') . '.php';
        if (class_exists($class_name))
        {
            return true;
        }
    }
    return false;
});

//  ...
\app\src\Timeout::start();

//  ...
include INC_ROOT . '/app/config/routes.php';

//  ...
$router = new \app\core\Router();
$router::engine();
