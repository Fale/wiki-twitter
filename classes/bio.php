<?php
require_once( "templateparser.php" );

class Bio extends TemplateParser
{
    public function tAll( $s )
    {
        $a = Array();
        array_push( $a, trim( $this->tBorn( $s ) ) );
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
    }

    public function tBorn( $s )
    {
        if( $this->array['AnnoNascita'] && $this->array['GiornoMeseNascita'] )
            return $this->fullName . " è nato il " . $this->array['GiornoMeseNascita'] . " #" . $this->array['AnnoNascita'] . " a " . $this->array['LuogoNascita'] . ". #sapevatelo $s";
    }
}

?>
