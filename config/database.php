<?php
class Database
{
    // private static $dbName = 'menully.db' ;
    // private static $dbHost = 'localhost' ;
    // private static $dbUsername = 'root';
    // private static $dbUserPassword = '';
    // private static $port = '';

    // private static $dbName = 'u437487943_fredowaredb' ;
    // private static $dbHost = 'localhost' ;
    // private static $dbUsername = 'u437487943_fredowaresql';
    // private static $dbUserPassword = 'feZxmasqw1212!@!@';
    // private static $port = '';

    private static $cont  = null;

    public function __construct() {
        die('Init function is not allowed');
    }

    public static function connect()
    {
        // Local environment
        if ($_SERVER['HTTP_HOST'] == 'localhost') {
          $dbName = 'menully.db' ;
          $dbHost = 'localhost' ;
          $dbUsername = 'root';
          $dbUserPassword = '';
          $port = '';
        }
        
        // Local production
        if ($_SERVER['HTTP_HOST'] == 'www.menully.com' || $_SERVER['HTTP_HOST'] == 'menully.com' || $_SERVER['HTTP_HOST'] == 'admin.menully.com') {
          $dbName = 'u437487943_menullydb' ;
          $dbHost = 'localhost' ;
          $dbUsername = 'u437487943_menully';
          $dbUserPassword = '9Jh3sMmO;';
          $port = '';
        }

       // One connection through whole application
       if ( null == self::$cont )
       {
        try
        {
          self::$cont =  new PDO("mysql:host=".$dbHost.";port=".$port.";"."dbname=".$dbName, $dbUsername, $dbUserPassword);
        }
        catch(PDOException $e)
        {
          die($e->getMessage());
        }
       }
       return self::$cont;
    }

    public static function disconnect()
    {
        self::$cont = null;
    }
}
?>
