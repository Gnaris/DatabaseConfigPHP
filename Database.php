<?php

class Database{

    private static $dsn = 'mysql:dbname=bourse;host=localhost';
    private static $login ='root';
    private static $motDePasse = '';
    private static $cnx = null;

    public static function getDatabase()
    {
        if(self::$cnx == null)
        {
            $cnx = new PDO(self::$dsn, self::$login, self::$motDePasse, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8']);
        }
        return $cnx;
    }
}

?>