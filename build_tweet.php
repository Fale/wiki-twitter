<?php
### CLASSES ###
require_once( "classes/db.php" );

class Amministrazioni
{
    private $db;
    private $array;

    public function __construct( $url )
    {
        $this->db = new Db();
        $this->array = $this->db->query( "SELECT * FROM amministrazioni WHERE `url` = '$url'" );
    }

    public function __destruct()
    {
        $this->db->close();
    }

    public function tAbitanti()
    {
        if( $this->array['grado'] == "3" )
            return "Il #comune di #" . $this->array['nome'] . " conta " . $this->array['abitanti'] . " #abitanti.";
    }
}

$url = "http://it.wikipedia.org/wiki/" . "Milano";
$a = new Amministrazioni( $url );
echo $a->tAbitanti();
?>
