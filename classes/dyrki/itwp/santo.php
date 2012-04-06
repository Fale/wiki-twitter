<?php
define( '__ROOT__', dirname( dirname( dirname( __FILE__ ) ) ) );
### CLASSES ###
require_once( __ROOT__ . "/classes/wiki/templateparser.php" );

class Sandto extends TemplateParser
{
    public function tAll( $s )
    {
        $a = Array();
        if( $this->devel['3'] )
            array_push( $a, trim( $this->tBornDie( $s ) ) );
        if( $this->devel['3'] )
            array_push( $a, trim( $this->tReligioni( $s ) ) );
        return array_filter( $a );
    }

    public function tBornDie( $s )
    {
        if( $this->array['Nato'] )
            return $this->array['Nome'] . " è nato nel #" . $this->array['Nato'] . "e morto nel #" . $this->array['Morto'] . ". #sapevatelo $s";
    }

    public function tReligioni( $s )
    {
        if( $this->array['Venerato da'] )
            return $this->array['Nome'] . $this->p( "Morto", "fu", "è" ) . " un santo venerato da #" . $this->array['Venerato da'] . ". #sapevatelo $s";
    }
}

?>
