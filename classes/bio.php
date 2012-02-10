<?php
require_once( "templateparser.php" );

class Bio extends TemplateParser
{
    public function tAll( $s )
    {
        $a = Array();
        array_push( $a, trim( $this->tBorn( $s ) ) );
        array_push( $a, trim( $this->tDie( $s ) ) );
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

    private function c( $field, $pre = "", $post = "", $e = "" )
    {
        if( $this->array[$field] )
            return " " . trim( $pre . $this->array[$field] . $post );
        elseif( $e )
            return " " . trim( $e );
    }
    
    public function tBorn( $s )
    {
        if( $this->array['AnnoNascita'] )
            if( $this->array['Sesso'] == "F" )
                return $this->fullName() . " è nata" . $this->c( 'GiornoMeseNascita', "il ", "", "nel" ) . " #" . $this->array['AnnoNascita'] . $this->c( 'LuogoNascita', "a #" ) . ". #sapevatelo $s";
            else
                return $this->fullName() . " è nato" . $this->c( 'GiornoMeseNascita', "il ", "", "nel" ) . " #" . $this->array['AnnoNascita'] . $this->c( 'LuogoNascita', "a #" ) . ". #sapevatelo $s";
    }

    public function tDie( $s )
    {
        if( $this->array['AnnoMorte'] )
            if( $this->array['Sesso'] == "F" )
                return $this->fullName() . " è morta" . $this->c( 'GiornoMeseMorte', "il ", "", "nel" ) . " #" . $this->array['AnnoMorte'] . $this->c( 'LuogoMorte', "a #" ) . ". #sapevatelo $s";
            else
                return $this->fullName() . " è morto" . $this->c( 'GiornoMeseMorte', "il ", "", "nel" ) . " #" . $this->array['AnnoMorte'] . $this->c( 'LuogoMorte', "a #" ) . ". #sapevatelo $s";
    }

    public function tWork( $s )
    {
        if( $this->array['Attività'] )
            if( $this->array['Sesso'] == "F" )
                return $this->fullName() . " è una #" . $this->array['Attività'] . $this->c( 'Nazionalità', "#" ) . ". #sapevatelo $s";
            else
                return $this->fullName() . " è un #" . $this->array['Attività'] . $this->c( 'Nazionalità', "#" ) . ". #sapevatelo $s";
    }
}

?>
