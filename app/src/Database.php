<?php


namespace app\src;


use PDO;

abstract class Database
{

    #   ... [%] ~@
    //  ...
    private static function get_instance(
        //  ... string $hostname = 'sql188.main-hosting.eu', string $data_name = 'u592941430_thesaurus'
        //  ... string $hostname = 'localhost', string $data_name = 'u592941430_thesaurus'
        string $hostname = 'localhost', string $data_name = 'thesaurus'
    ): string
    {   #   ... code

        //  ...
        return 'mysql:host=' . $hostname . ';dbname=' . $data_name;

    }   #   ... encode

    #   ... [%] ~@
    //  ...
    protected static function connect(
        //  ... string $username = 'u592941430_root', string $password = 'Sam19D3mel56A'
        string $username = 'root', string $password = 'root'
    ): PDO
    {   #   ... code

        //  ...
        $pdo = new PDO(self::get_instance(), $username, $password);

        //  ...
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        //  ...
        return $pdo;

    }   #   ... encode

    #   ... [%] ~@
    //  ...
    public static function query(
        string $sql, array $params = array()
    )
    {   #   ... code

        //  ...
        $statement = self::connect()->prepare($sql);

        //  ...
        $statement->execute($params);

        //  ...
        if (\explode(' ', $sql)[0] === 'SELECT')
        {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }

        //  ...
        return $statement;

    }   #   ... encode

}
