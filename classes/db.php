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
        $out = Array();
        foreach ($this->db->query($q) as $row)
            array_push( $out, $row );
        return $out;
    }

    public function smartinsert( $array, $table, $key )
    {
        $c = $this->db->exec( "SELECT * FROM $table WHERE `$key`='" . $array[$key] . "'" );
        if( !$c )
        {
            $query = "INSERT INTO `$table` SET ";
            foreach( $array as $k => $v )
                $query .= "`" . $k . "` = '" . $this->db->quote( $v ) . "', ";
            $query = substr( $query, 0, -2 ) . ";";
            return $this->db->exec( $query );
        } else
            return 0;
    }

    public function connect()
    {
        global $mysqlHost, $mysqlUser, $mysqlPass, $mysqlDb;
        $db = new PDO("mysql:host=$mysqlHost;dbname=$mysqlDb", $mysqlUser, $mysqlPass);
        return $db;
    }
}
?>