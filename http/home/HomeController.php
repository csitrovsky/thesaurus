<?php


namespace http\home;


use app\core\Controller;
use app\core\View;
use app\src\Errors;

class HomeController extends Controller
{

    #   ... [%] ~@
    //  ...
    public static function index(): void
    {   #   ... code
        
        //  ...
        View::rendering($vars = array(
            'errors' => false
        ));

        //  ...
        Errors::output($code = 200,
            'The page is fully loaded'
        );

        //  ...
        exit();

    }   #   ... encode

}
