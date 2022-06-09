<?php


namespace http\experimentation;


use app\core\Controller;
use app\core\View;
use app\src\Errors;

class ExperimentationController extends Controller
{

    #   ... [%] ~@
    //  ...
    public static function online(): void
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
