<?php


namespace http\thesaurus;


use app\core\Controller;
use app\core\View;
use app\src\Errors;

class ThesaurusController extends Controller
{

    #   ... [%] ~@
    //  ...
    public static function search(): void
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
