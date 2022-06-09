<?php


namespace api\http;


use api\Api;
use app\src\Customer;

class Experimentation extends Api
{

    #   ... [%] ~@
    //  ...
    protected static function get()
    {   #   ... code

        //  ...
        return self::response('Data error', 404);

    }   #   ... encode

    #   ... [%] ~@
    //  ...
    protected static function post()
    {   #   ... code

        //  ...
        if (\app\src\Customers::is_logged_in())
        {
            self::query('INSERT INTO `answers` (`id`, `user_id`, `birthdate`, `gender`, `spoken_language`, `specialty`, `reaction`, `motivation`, `timestamp`) VALUES (NULL, :user_id, \'1\', NULL, NULL, NULL, :reaction, :motivation, CURRENT_TIMESTAMP)', array(
                ':user_id' => \app\src\Customers::is_logged_in(),
                ':reaction' => $_POST['reaction'], ':motivation' => $_POST['motivation']
            ));
            return self::response(true, 200);
        }
        
        self::query('INSERT INTO `answers` (`id`, `user_id`, `birthdate`, `gender`, `spoken_language`, `specialty`, `reaction`, `motivation`, `timestamp`) VALUES (NULL, NULL, \'1\', NULL, NULL, NULL, :reaction, :motivation, CURRENT_TIMESTAMP)', array(
            ':reaction' => $_POST['reaction'], ':motivation' => $_POST['motivation']
        ));
        return self::response(true, 200);

    }   #   ... encode

    #   ... [%] ~@
    //  ...
    protected static function put()
    {   #   ... code

        //   ...
        return self::response('Update error', 400);

    }   #   ... encode

    #   ... [%] ~@
    //  ...
    protected static function delete()
    {   #   ... code

        //   ...
        return self::response('Delete error', 500);

    }   #   ... encode

}
