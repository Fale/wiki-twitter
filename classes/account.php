<?php

### SETTINGS ###
require_once( "settings/db.php" );
require_once( "settings/app.php" );

### CLASSES ###
require_once( "classes/twitter/twitter.class.php" );

class Account
{
    private $db;
    private $twitter;

    public function __construct( $account_ID )
    {
        global $twitterKey, $twitterSecret;
        $this->db = $this->connect();
        $r = mysql_query( "SELECT * FROM accounts WHERE ID=$account_ID", $this->db );
        if ( !$r )
            die( "Invalid query: " . mysql_error() );
        $row = mysql_fetch_assoc( $r );
        $token = $row['token'];
        $secret = $row['secret'];
        $this->twitter = new Twitter( $twitterKey, $twitterSecret, $token, $secret );
    }

    public function add( $tweet )
    {
        $t = mysql_real_escape_string( $tweet );
        $query = sprintf( "INSERT INTO `tweets`" 
            ."(`account`, `text`)" 
            ."VALUES" 
            ."('1','%s')", 
            mysql_real_escape_string($tweet) 
        ); 
        $r = mysql_query( $query );
        if ( !$r )
            die( "Invalid query: " . mysql_error() );

    }

    public function tweet($test = 0)
    {
        $r = mysql_query( "SELECT * FROM tweets ORDER BY last, priority DESC, RAND() LIMIT 1" );
        if( !$r )
            die( "Invalid query: " . mysql_error() );
        $row = mysql_fetch_assoc( $r );
        if( !$test )
            $t = $this->twitter->send( utf8_encode( $row['text'] ) );
        else
            echo $row['text'];
        if( $t != FALSE && !$test)
        {
            $r = mysql_query( "UPDATE tweets SET last=DATE(NOW()) WHERE ID=" . $row['ID'] );
            if( !$r )
                die( "Invalid query:" . mysql_error() );
        }
        return TRUE;
    }

    private static function connect()
    {
        global $mysqlHost, $mysqlUser, $mysqlPass, $mysqlDb;
        $db = mysql_connect( $mysqlHost, $mysqlUser, $mysqlPass );
        if ( !$db )
            die( "Could not connect: " . mysql_error() );
        $db_selected = mysql_select_db( $mysqlDb, $db );
        if ( !$db_selected )
            die ( "Can't use foo: " . mysql_error() );
        return $db;
    }

    private static function close()
    {
        mysql_close( $this->db );
    }

    public static function install()
    {
        $db = Account::connect();
        $accounts = "CREATE TABLE IF NOT EXISTS `accounts` (
            `ID` INT( 6 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            `token` VARCHAR( 64 ) NOT NULL ,
            `secret` VARCHAR( 64 ) NOT NULL
        ) ENGINE = MYISAM ;";
        $r = mysql_query( $accounts, $db );
        if ( !$r )
            die( "Invalid query: " . mysql_error() );

        $tweets = "CREATE TABLE IF NOT EXISTS `tweets` (
            `ID` INT( 6 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            `account` INT( 6 ) UNSIGNED NOT NULL ,
            `text` VARCHAR( 140 ) NOT NULL ,
            `last` DATE NOT NULL
        ) ENGINE = MYISAM ;";
        $r = mysql_query( $tweets, $db );
        if ( !$r )
            die( "Invalid query: " . mysql_error() );
//        Account::close( $db );
    }
} 
?>