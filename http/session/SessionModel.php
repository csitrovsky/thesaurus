<?php


namespace http\session;

use \app\core\Model;

class SessionModel extends Model
{

    #   ... [%] ~@
    //  ...
    public static function log_in(
        $username, $password
    )
    {   #   ... code

        //  ...
        if (self::query('SELECT * FROM `customers` WHERE `username` LIKE :username', array(
            ':username' => $username
        )))
        {

            //  ...
            if (password_verify($password, self::query('SELECT `password` FROM `customers` WHERE `username` LIKE :username', array(
                ':username' => $username
            ))[0]['password']))
            {

                //  ...
                $crypt_strong = True;
                $token = bin2hex(openssl_random_pseudo_bytes(
                    64, $crypt_strong
                ));

                //  ...
                $user_id = self::query('SELECT `id` FROM `customers` WHERE `username` LIKE :username', array(
                    ':username' => $username
                ))[0]['id'];

                //  ...
                if (self::query('SELECT * FROM `authorized` WHERE `user_id` = :user_id AND `activity` = \'1\' AND `ip_address` LIKE :ip_address ORDER BY `timestamp` ASC, `activity` DESC', array(
                    ':user_id' => $user_id, ':ip_address' => $_SERVER['REMOTE_ADDR']
                ))) {

                    //   ...
                    $the_last_authentication = self::query('SELECT `id` FROM `authorized` WHERE `user_id` = :user_id AND `activity` = \'1\' AND `ip_address` LIKE :ip_address ORDER BY `timestamp` ASC, `activity` DESC LIMIT 1', array(
                        ':user_id' => $user_id, ':ip_address' => $_SERVER['REMOTE_ADDR']
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
                return true;

            }

            //  ...
            return array(
                'error' => 'Неверный пароль'
            );

        }

        //  ...
        return array(
            'error' => 'Пользователь не был найден'
        );

    }   #   ... encode

}
