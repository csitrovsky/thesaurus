<?php


namespace http\account;


use \app\src\Mailers;
use \app\core\Model;

class AccountModel extends Model
{

    #   ... [%] ~@
    //  ...
    public static function create_user_profile(
        $email_address, $complete_name, $username, $password
    )
    {   #   ... code

        //  ...
        if (self::query('SELECT * FROM `customers` WHERE `username` LIKE :username', array(
            ':username' => \htmlentities(\trim($username, '/'))
        )))
        {
            return array(
                'error' => 'Пользователь с тами \'Пользовательским именем\' уже существует.'
            );
        }

        //  ...
        $crypt_strong = TRUE;
        $token = bin2hex(openssl_random_pseudo_bytes(
            64, $crypt_strong
        ));

        //  ...
        self::query('INSERT INTO `customers` (`id`, `unique_address`, `email_address`, `username`, `password`, `token`, `complete_name`, `birthdate`, `gender`, `spoken_language`, `specialty`, `accessibility`, `activation`, `timestamp`) VALUES (NULL, :unique_address, :email_address, :username, :password, :token, :complete_name, NULL, NULL, NULL, NULL, \'0\', \'0\', CURRENT_TIMESTAMP)', array(
            ':unique_address' => 'id::' . $username,
            ':email_address' => $email_address,
            ':username' => $username,
            ':password' => \password_hash(
                $password, PASSWORD_BCRYPT
            ),
            ':token' => sha1($token), ':complete_name' => $complete_name
        ));

        //  ...
        $user_id = self::query('SELECT `id` FROM `customers` WHERE `username` LIKE :username', array(
            ':username' => $username
        ))[0]['id'];

        //  ...
        self::query('INSERT INTO `authorized` (`id`, `user_id`, `token`, `ip_address`, `activity`, `timestamp`) VALUES (NULL, :user_id, :token, NULL, \'1\', CURRENT_TIMESTAMP)', array(
            ':user_id' => $user_id, ':token' => \sha1($token)
        ));

        //  ...
        $_SESSION['VACCINE'] = $token;
        setcookie('EPS_ID', '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);

        //  ...
        self::query('INSERT INTO `activation` (`id`, `user_id`, `token`, `activation`, `timestamp`) VALUES (NULL, :user_id, :token, \'0\', CURRENT_TIMESTAMP)', array(
            ':user_id' => $user_id, ':token' => \sha1($token)
        ));

        //  ...
        $subject  = 'Registration on the website Experimentation.online';

        //  ...
        $message = '<pre style="margin: 0 auto; position: relative; padding: 16px 48px; line-height: 1.5; white-space: normal; font-family: monospace;"><h2 style="font-size: 16px; font-weight: 400; font-family: monospace; display: inline-block; color: #1e2022; margin-bottom: 16px;"><span style="background: #1e2022; color: white; padding: 4px 16px; display: inline-block; border-radius: 4px;">Hello, <span style="text-transform: capitalize;">' . ucfirst(mb_strtolower($username)) . '</span>!</span> You have successfully registered on the site <a href="' . $_SERVER['SERVER_NAME'] . '" target="_blank" style="background: #f8f8f8; padding: 4px 16px; border-radius: 4px; text-decoration: none; display: inline-block;"><span style="color: #1e2022;">Experimentation.online</span></a></h2><p style="margin-bottom: 16px; font-size: 16px; font-family: monospace; color: #1e2022;">To activate your account, please confirm your account creation using this link:</p><p style="margin-bottom: 16px; font-size: 16px; font-family: monospace;"><a href="' . $_SERVER['SERVER_NAME'] . '/account/activation?token=' . $token . '" style="text-decoration: none;"><span style="color: #0845f5;">https://experimentation.online/account/activation?token=' . $token . '</span></a></p></pre>';

        //  ...
        Mailers::sending_letter_utf8($email_address, $message, $subject);

        //  ...
        return true;

    }   #   ... encode

}
