<?php
require_once( "../templateparser.php" );

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

    public function p( $field, $y = "", $n = "" )
    {
        if( $this->array[$field] )
            return " " . trim( $y );
        elseif( $n )
            return " " . trim( $n );
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
