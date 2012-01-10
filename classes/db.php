<?php

### SETTINGS ###
require_once( "settings/db.php" );

class Db
{
    private $db;

    public function __construct()
    {
        $this->db = $this->connect();
    }

    public function query( $q )
    {
        $r = mysql_query( $q );
        if( !$r )
            die( "Invalid query: " . mysql_error() );
        return mysql_fetch_assoc( $r );
    }

    public function smartinsert( $array, $table, $key )
    {
        // Create the Query
        $query = "INSERT INTO `$table` SET ";
        foreach( $array as $k => $v )
            $query .= "`" . $k . "` = '" . mysql_escape_string( $v ) . "', ";
        $query = substr( $query, 0, -2 ) . ";";
echo $query . "\n\n\n";
        $c = mysql_query( "SELECT * FROM $table WHERE `$key`='" . $array[$key] . "'" );
        if( !$c )
            die( "Invalid query: " . mysql_error() );
        elseif ( !mysql_num_rows( $c ) )
        {
            $r = mysql_query( $query );
            if( !$r )
                die( "Invalid query: " . mysql_error() );
        }
        return mysql_affected_rows();
    }

    public function connect()
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

    public function close()
    {
        mysql_close( $this->db );
    }
}
?>
