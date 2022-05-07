<?php

class DatabaseConnSingleton {

    private static $dbhost = "dbserver";
    private static $dbuser = "grupo07";
    private static $dbpass = "einahH7eir";
    private static $db = "db_grupo07";
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
