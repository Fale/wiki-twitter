<?php
require_once( "templateparser.php" );

class Film extends TemplateParser
{
    public function tAll( $s )
    {
        $a = Array();
        array_push( $a, trim( $this->tBorn( $s ) ) );
        array_push( $a, trim( $this->tGenere( $s ) ) );
        array_push( $a, trim( $this->tDurata( $s ) ) );
        return array_filter( $a );
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
    
    public function tAnno( $s )
    {
        return $this->array['titoloitaliano'] . " è un #film del #" . $this->array['annousita'] . ". #sapevatelo $s";
    }

    public function tGenere( $s )
    {
        return $this->array['titoloitaliano'] . " è un #film #" $this->array['genere'] . ". #sapevatelo $s";
    }

    public function tDurata( $s )
    {
        return "La #durata del #film \"" . $this->array['titoloitaliano'] . "\" è di #" . $this->array['durata'] . ". #sapevatelo $s";
    }
}

?>
