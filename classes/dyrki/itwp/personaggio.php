<?php
define( '__ROOT__', dirname( dirname( dirname( __FILE__ ) ) ) );
### CLASSES ###
require_once( __ROOT__ . "/classes/wiki/templateparser.php" );

class Personaggio extends TemplateParser
{
    public function tAll( $s )
    {
        $a = Array();
        if( $this->devel['3'] )
            array_push( $a, trim( $this->tNome( $s ) ) );
        if( $this->devel['3'] )
            array_push( $a, trim( $this->tAttore( $s ) ) );
        return array_filter( $a );
    }
    
    public function tNome( $s )
    {
        if( $this->array['Nome'] && $this->array['Universo'] && $this->array['Sesso'] )
            if( !$this->array['razza'] )
                return $this->array['Name'] . " è un personaggio di #" . $this->array['Universo'] . ". #sapevatelo $s";
            else
                return $this->array['Name'] . " è un #" . $this->array['Razza'] . " di #" . $this->array['Universo'] . ". #sapevatelo $s";
    }

    public function tAttore( $s )
    {
        if( $this->array['Nome'] && $this->array['Attore'] )
            return $this->array['Attore'] . " è stato il primo attore ad interpretare #" . $this->array['Name'] . ". #sapevatelo $s";
    }
}

?>
