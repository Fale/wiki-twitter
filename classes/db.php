<?php

### SETTINGS ###
require_once( "settings/db.php" );

class Db
{
    /**
     * Database link
     *
     * @access private
     * @author Fabio Alessandro Locati
     */
    private $db;
    
    /**
     * Debug Level
     *
     * Level 0: No debug
     * Level 1: Print errors (default)
     * Level 2: Print errors and query
     * Level 3: Print errors, query and query results
     * 
     * @access private
     * @todo Level 4: Print errors, query, query results and values
     * @author Fabio Alessandro Locati
     */
    private $debug;

    /**
     * Class constructor
     *
     * @param integer debug level (default: 1)
     * @access public
     * @author Fabio Alessandro Locati
     */
    public function __construct( $debug = 1 )
    {
        $this->debug = $debug;
        $this->db = $this->connect();
    }

    /**
     * Execute SQL query
     *
     * This function will execute a given SQL query in string mode
     *
     * @param string $q The query you want to run
     * @return array The query result
     * @author Fabio Alessandro Locati
     */
    public function query( $q )
    {
        if( $this->debug >= 2 )
            echo $q . "\n";
        $out = Array();
        foreach ($this->db->query($q) as $row)
            array_push( $out, $row );
        if( $this->debug >= 3 )
            print_r( $out );
        return $out;
    }

    /**
     * Execute SQL query
     *
     * This function will execute a given SQL query in string mode
     *
     * @param string $q The query you want to run
     * @return array The query result
     * @author Fabio Alessandro Locati
     */
    public function singleQuery( $q )
    {
        if( $this->debug >= 2 )
            echo $q . "\n";
        return $this->db->query( $q );
    }

    /**
     * Update SQL rows
     *
     * This function will create and execute an SQL UPDATE query
     *
     * @param array $array The data you want in your query
     * @param string $table The name of the table
     * @param string $key The name of the column you want to match
     * @return array The query result
     * @author Fabio Alessandro Locati
     * @todo Move $key from a string to array
     */
    public function update( $array, $table, $key )
    {
        $query = "UPDATE `$table` SET ";
        foreach( $array as $k => $v )
            $query .= "`" . $k . "` = " . $this->db->quote( $v ) . ", ";
        $query = substr( $query, 0, -2 );
        $query .= " WHERE `$key`=" . $this->db->quote( $array[$key] ) . ";";
        return $this->singleQuery( $query );
    }

    /**
     * Insert SQL row
     *
     * This function will create and execute an SQL INSERT query
     *
     * @param array $array The data you want in your query
     * @param string $table The name of the table
     * @return array The new line ID
     * @author Fabio Alessandro Locati
     */
    public function insert( $array, $table )
    {
        $query = "INSERT INTO `$table` SET ";
        foreach( $array as $k => $v )
            $query .= "`" . $k . "` = " . $this->db->quote( $v ) . ", ";
        $query = substr( $query, 0, -2 ) . ";";
        return $this->db->query( $query );
    }

    /**
     * Manage smartly SQL query
     *
     * This function will create the row if it is not present. If the row is present, it will update it if $overwrite is set. Otherwise nothing will happened
     *
     * @param array $array The data you want in your query
     * @param string $table The name of the table
     * @param string $key The name of the column you want to match
     * @param boolean $overwrite Do you want to update the row, if it does exists? (default= FALSE)
     * @return array The query result
     * @author Fabio Alessandro Locati
     * @todo Move $key from a string to array
     */
    public function smartinsert( $array, $table, $key, $overwrite = FALSE )
    {
        $c = $this->query( "SELECT * FROM $table WHERE `$key`=" . $this->db->quote( $array[$key] ) . ";" );
        if( !$c )
            return $this->insert( $array, $table );
        elseif( $overwrite == TRUE )
            return $this->update( $array, $table, $key );
        else
            return 0;
    }

    /**
     * Connect to SQL database
     *
     * This function will conect to SQL Database
     *
     * @return array The database link
     * @access private
     * @author Fabio Alessandro Locati
     */
    private function connect()
    {
        global $mysqlHost, $mysqlUser, $mysqlPass, $mysqlDb;
        $db = new PDO( "mysql:host=$mysqlHost;dbname=$mysqlDb", $mysqlUser, $mysqlPass );
        $db->setAttribute( PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true );
        if( $this->debug >= 1 )
            $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
        return $db;
    }
}
?>
