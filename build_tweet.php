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

    public function incipit()
    {
        switch( $this->array['grado'] )
        {
            case "1":
                return "La #regione";
            case "2":
                return "La #provincia di";
            case "3":
                return "Il #comune di";
                break;
            case "4":
                break;
            default:
                die( "Wrong grado" );
        }
    }

    public function tAll()
    {
        $a = Array();
        array_push( $a, $this->tAbitanti() );
        array_push( $a, $this->tSuperficie() );
        return $a;
    }

    public function tAbitanti()
    {
        return $this->incipit() . " #" . $this->array['nome'] . " conta " . $this->array['abitanti'] . " #abitanti.";
    }

    public function tSuperficie()
    {
        return $this->incipit() . " #" . $this->array['nome'] . " si espande su " . $this->array['superficie'] . " #km².";
    }
}

$url = "http://it.wikipedia.org/wiki/" . "Milano";
$a = new Amministrazioni( $url );
print_r( $a->tAll() );
?>
