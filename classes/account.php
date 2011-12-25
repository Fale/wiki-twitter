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

    public function tweet()
    {
        $r = mysql_query( "SELECT * FROM tweets ORDER BY last" );
        if ( !$r )
            die( "Invalid query: " . mysql_error() );
        $row = mysql_fetch_assoc( $r );
        $t = $this->twitter->send( utf8_encode( $row['text'] ) );
        if ( $t != FALSE )
        {
            $r = mysql_query( "UPDATE tweets SET last=DATE(NOW()) WHERE ID=" . $row['ID'] );
            if ( !$r )
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
        if ( !$db_selected ) {
            die ( "Can't use foo: " . mysql_error() );
        }
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

    function mysql_import($filename)
    {
        $return = false;
        $sql_start = array('INSERT', 'UPDATE', 'DELETE', 'DROP', 'GRANT', 'REVOKE', 'CREATE', 'ALTER');
    $sql_run_last = array('INSERT');

    if (file_exists($filename)) {
        $lines = file($filename);
        $queries = array();
        $query = '';

        if (is_array($lines)) {
            foreach ($lines as $line) {
                $line = trim($line);

                if(!preg_match("'^--'", $line)) {
                    if (!trim($line)) {
                        if ($query != '') {
                            $first_word = trim(strtoupper(substr($query, 0, strpos($query, ' '))));
                            if (in_array($first_word, $sql_start)) {
                                $pos = strpos($query, '`')+1;
                                $query = substr($query, 0, $pos) . $wpdb->prefix . substr($query, $pos);
                            }

                            $priority = 1;
                            if (in_array($first_word, $sql_run_last)) {
                                $priority = 10;
                            } 

                            $queries[$priority][] = $query;
                            $query = '';
                        }
                    } else {
                        $query .= $line;
                    }
                }
            }

            ksort($queries);

            foreach ($queries as $priority=>$to_run) {
                foreach ($to_run as $i=>$sql) {
                    mysql_query($sql, $this->db);
                }
            }
        }
    }
}
} 

?>

