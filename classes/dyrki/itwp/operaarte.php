<?php
define( '__ROOT__', dirname( dirname( dirname( __FILE__ ) ) ) );
### CLASSES ###
require_once( __ROOT__ . "/classes/wiki/templateparser.php" );

class OperaArte extends TemplateParser
{
    public function tAll( $s )
    {
        $a = Array();
        if( $this->array['Titolo'] )
        {
            array_push( $a, trim( $this->tAutore( $s ) ) );
        }
        return array_filter( $a );
    }

    public function tAutore( $s )
    {
        if( $this->array['Autore'] )
            return "\"" . $this->array['Titolo'] . "\" è un'opera d'Arte di #" . $this->array['Autore'] . ". #sapevatelo $s";
    }
}
?>
