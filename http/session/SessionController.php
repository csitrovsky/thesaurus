<?php


namespace http\session;


use app\core\Controller;
use app\core\View;
use app\src\Errors;

class SessionController extends Controller
{

    #   ... [%] ~@
    //  ...
    public static function start(): void
    {   #   ... code

        //  ...
        $errors = false;

        //  ...
        if (isset($_POST['button']))
        {

            //  ...
            if (!empty($_POST['personal']['username']))
            {
                $username = $_POST['personal']['username'];
            } else {
                $username = '';
                $errors['username'] = 'Вы забыли ввести свое имя пользователя';
            }

            //  ...
            if (!empty($_POST['personal']['password']))
            {
                $password = $_POST['personal']['password'];
            } else {
                $password = '';
                $errors['password'] = 'Вы забыли вести свой пароль';
            }

            //  ...
            if (isset($errors) !== null)
            {
                $result = self::model()->log_in(
                    $username, $password
                );
                if (isset($result['error']))
                {
                    $errors['error'] = $result['error'];
                } else {
                    \header('location: /');
                    exit();
                }
            }

        }

        //  ...
        View::rendering($vars = array(
            'errors' => $errors
        ));

        //  ...
        Errors::output($code = 200,
            'The page is fully loaded'
        );

        //  ...
        exit();

    }   #   ... encode

}
