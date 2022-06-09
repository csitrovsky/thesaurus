<?php


namespace api\http;


use api\Api;

class Stimulus extends Api
{

    #   ... [%] ~@
    //  ...
    protected static function get()
    {   #   ... code

        //  ...
        return self::response(self::query('SELECT DISTINCT `motivation` FROM `answers` WHERE `id` ORDER BY RAND() LIMIT 5'), 200);

    }   #   ... encode

    #   ... [%] ~@
    //  ...
    protected static function post()
    {   #   ... code

        //  ...
        return self::response('Post error', 500);

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
