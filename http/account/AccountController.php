<?php


namespace http\account;


use app\core\Controller;
use app\core\View;
use app\src\Errors;

class AccountController extends Controller
{

    #   ... [%] ~@
    //  ...
    public static function create(): void
    {   #   ... code

        //
        $errors = false;

        //  ...
        if (isset($_POST['button']))
        {

            //  ...
            if (!empty($_POST['personal']['email_address']))
            {
                if (filter_var($_POST['personal']['email_address'], FILTER_VALIDATE_EMAIL))
                {
                    $email_address = $_POST['personal']['email_address'];
                } else {
                    $email_address = '';
                    $errors['email'] = '';
                }
            } else {
                $email_address = '';
                $errors['email'] = 'Вы забыли ввести свой адрес электронной почты';
            }

            //  ...
            if (!empty($_POST['personal']['complete_name']))
            {
                $complete_name = $_POST['personal']['complete_name'];
            } else {
                $complete_name = '';
                $errors['complete_name'] = 'Вызабили ввести полное имя (ФИО)';
            }

            //  ...
            if (!empty($_POST['personal']['username']))
            {
                $username = $_POST['personal']['username'];
            } else {
                $username = '';
                $errors['username'] = 'Вызабыли ввести пользователькое имя';
            }

            //  ...
            if (!empty($_POST['personal']['password']))
            {
                if (preg_match('/^[a-zA-Z0-9]*$/', $_POST['personal']['password']))
                {
                    $password = $_POST['personal']['password'];
                } else {
                    $password = '';
                    $errors['password'] = '';
                }
            } else {
                $password = '';
                $errors['password'] = 'Вы забыли ввести пароль';
            }

            //  ...
            if (isset($errors) !== null)
            {
                $result = self::model()->create_user_profile(
                    $email_address, $complete_name, $username, $password
                );
                if (isset($result['error']))
                {
                    $errors['error'] = $result['error'];
                } else {
                    \header('location: /session/start');
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

    #   ... [%] ~@
    //  ...
    public static function settings(): void
    {   #   ... code

        //  ...
        View::$layout = 'dashboard';
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
