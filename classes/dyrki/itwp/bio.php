<?php
define( '__ROOT__', dirname( dirname( dirname( __FILE__ ) ) ) );
### CLASSES ###
require_once( __ROOT__ . "/classes/wiki/templateparser.php" );

class Bio extends TemplateParser
{
    public function tAll( $s )
    {
        $a = Array();
        if( $this->devel['1'] )
            array_push( $a, trim( $this->tBorn( $s ) ) );
        if( $this->devel['1'] )
            array_push( $a, trim( $this->tDie( $s ) ) );
        if( $this->devel['1'] )
            array_push( $a, trim( $this->tWork( $s ) ) );
        return array_filter( $a );
    }

    public function fullName()
    {
        $o = "";
        if( $this->array['Titolo'] )
            $o .= $this->array['Titolo'] . " ";
        if( $this->array['Nome'] )
            $o .= $this->array['Nome'] . " ";
        if( $this->array['Cognome'] )
            $o .= "#" . $this->array['Cognome'] . " ";
        return trim( $o );
    }

    public function tBorn( $s )
    {
        if( $this->array['AnnoNascita'] )
            return $this->fullName() . " è nat" . ($this->array['Sesso'] == "F" ? "a":"o") . $this->c( 'GiornoMeseNascita', "il ", "", "nel" ) . " #" . $this->array['AnnoNascita'] . $this->c( 'LuogoNascita', "a #" ) . ". #sapevatelo $s";
    }

    public function tDie( $s )
    {
        $this->array['AnnoMorte'] = str_replace( "?", "", $this->array['AnnoMorte'] );
        if( $this->array['AnnoMorte'] )
            return $this->fullName() . " è mort" . ($this->array['Sesso'] == "F" ? "a":"o") . $this->c( 'GiornoMeseMorte', "il ", "", "nel" ) . " #" . $this->array['AnnoMorte'] . $this->c( 'LuogoMorte', "a #" ) . ". #sapevatelo $s";
    }

    public function tWork( $s )
    {
        if( $this->array['Attività'] )
            return $this->fullName() . $this->p( "AnnoMorte", "fu", "è" ) . " un" . ($this->array['Sesso'] == "F" ? "a":"") . " #" . $this->array['Attività'] . $this->c( 'Nazionalità', "#" ) . ". #sapevatelo $s";
    }
}

?>
