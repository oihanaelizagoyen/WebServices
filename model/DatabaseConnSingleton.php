<?php

class DatabaseConnSingleton {

    private static $dbhost = "localhost";
    private static $dbuser = "root";
    private static $dbpass = "";
    private static $db = "db_grupo28";
    private static $conn = null;

    public static function getConn(){
        if (null === self:: $conn ){
            self::$conn = new mysqli(self::$dbhost, self::$dbuser, self::$dbpass, self::$db) or die("Connect failed: %s\n". self::$conn -> error);
        }
        return self::$conn;
    }
    public static function closeConn()
    {
        self::$conn->close();
    }

}
