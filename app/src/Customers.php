<?php


namespace app\src;


class Customers extends Database
{

    #   ... [%] ~@
    //  ...
    public static function is_logged_in()
    {   #   ... code

        //  ...
        if (isset($_SESSION['VACCINE'], $_COOKIE['EPS_ID']))
        {

            //  ...
            if (self::query('SELECT `id` FROM `authorized` WHERE `token` = :token', array(
                ':token' => sha1($_SESSION['VACCINE'])
            )))
            {

                //  ...
                $user_id = self::query('SELECT `user_id` FROM `authorized` WHERE `token` = :token', array(
                    ':token' => sha1($_SESSION['VACCINE'])
                ))[0]['user_id'];

                //  ...
                if (isset($_SESSION['VACCINE'], $_COOKIE['EPS_ID'])) {
                    return $user_id;
                }

                //  ...
                $crypt_strong = True;
                $token = bin2hex(openssl_random_pseudo_bytes(
                    64, $crypt_strong
                ));

                //  ...
                if (self::query('SELECT * FROM `authorized` WHERE `user_id` = :user_id AND `activity` = \'1\' AND `ip_address` LIKE :ip_address ORDER BY `timestamp` ASC, `activity` DESC', array(
                    ':user_id' => self::is_logged_in(), ':ip_address' => $_SERVER['REMOTE_ADDR']
                ))) {

                    //   ...
                    $the_last_authentication = self::query('SELECT `id` FROM `authorized` WHERE `user_id` = :user_id AND `activity` = 1 AND `ip_address` LIKE :ip_address ORDER BY `timestamp` ASC, `activity` DESC LIMIT 1', array(
                        ':user_id' => self::is_logged_in(), ':ip_address' => $_SERVER['REMOTE_ADDR']
                    ))[0]['id'];

                    //  ...
                    self::query('UPDATE `authorized` SET `activity` = \'0\' WHERE `authorized`.`id` = :id AND `authorized`.`ip_address` LIKE :ip_address;', array(
                        ':id' => $the_last_authentication, ':ip_address' => $_SERVER['REMOTE_ADDR']
                    ));

                }

                //  ...
                self::query('INSERT INTO `authorized` (`id`, `user_id`, `token`, `ip_address`, `activity`, `timestamp`) VALUES (NULL, :user_id, :token, :ip_address, \'1\', CURRENT_TIMESTAMP)', array(
                    ':user_id' => $user_id, ':token' => sha1($token), ':ip_address' => $_SERVER['REMOTE_ADDR']
                ));

                //  ...
                $_SESSION['VACCINE'] = $token;
                setcookie('EPS_ID', '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);

                //  ...
                return $user_id;

            }

            //  ...
            return false;

        }

        //  ...
        return false;

    }   #   ... encode

    #   ... [%] ~@
    //  ...
    public static function log_off(): bool
    {   #   ... code

        //  ...
        if (self::query('SELECT * FROM `authorized` WHERE `user_id` = :user_id AND `activity` = \'1\' AND `ip_address` LIKE :ip_address ORDER BY `timestamp` ASC, `activity` DESC', array(
            ':user_id' => self::is_logged_in(), ':ip_address' => $_SERVER['REMOTE_ADDR']
        ))) {

            //   ...
            $the_last_authentication = self::query('SELECT `id` FROM `authorized` WHERE `user_id` = :user_id AND `activity` = 1 AND `ip_address` LIKE :ip_address ORDER BY `timestamp` ASC, `activity` DESC LIMIT 1', array(
                ':user_id' => self::is_logged_in(), ':ip_address' => $_SERVER['REMOTE_ADDR']
            ))[0]['id'];

            //  ...
            self::query('UPDATE `authorized` SET `activity` = \'0\' WHERE `authorized`.`id` = :id AND `authorized`.`ip_address` LIKE :ip_address;', array(
                ':id' => $the_last_authentication, ':ip_address' => $_SERVER['REMOTE_ADDR']
            ));

        }

        //  ...
        $_SESSION = '';

        //  ...
        session_destroy();
        setcookie('EPS_ID', '', (time() - 3600), '/', NULL, NULL, TRUE);

        //  ...
        return true;

    }   #   ... encode

}
