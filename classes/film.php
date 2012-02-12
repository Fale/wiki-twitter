<?php
require_once( "templateparser.php" );

class Film extends TemplateParser
{
    public function tAll( $s )
    {
        $a = Array();
        array_push( $a, trim( $this->tAnno( $s ) ) );
        array_push( $a, trim( $this->tGenere( $s ) ) );
        array_push( $a, trim( $this->tDurata( $s ) ) );
        array_push( $a, trim( $this->tRegista( $s ) ) );
        array_merge( $a, $this->tAttori( $s ) );
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
        return $this->array['titoloitaliano'] . " è un #film #" . $this->array['genere'] . ". #sapevatelo $s";
    }

    public function tDurata( $s )
    {
        return "La #durata del #film \"" . $this->array['titoloitaliano'] . "\" è di #" . $this->array['durata'] . ". #sapevatelo $s";
    }

    public function tRegista( $s )
    {
        if( $this->array['regista'] )
            if( preg_match( "/,/i", $this->array['regista'] ) || preg_match( "/ e /i", $this->array['regista'] ) )
                return "I #registi del #film \"" . $this->array['titoloitaliano'] . "\" sono " . $this->array['regista'] . ". #sapevatelo $s";
            else
                return "Il #regista del #film \"" . $this->array['titoloitaliano'] . "\" è " . $this->array['regista'] . ". #sapevatelo $s";
    }

    public function tAttori( $s )
    {
        if( $this->array['attori'] )
        {
            $out = Array();
            $attori = explode( "*", $this->array['attori'] );
            foreach( $attori as $attore )
            {
                preg_match( "/\*(.*):(.*)", $attore, $m );
                if( $m[1] && $m[2] )
                {
                    $o = $m[1] . " ha #interpretato " . $m[2] . " nel #film " . $this->array['titoloitaliano'] . ". #sapevatelo $s";
                    array_push( $out, trim( $o );
                }
            }
            return $out;
        }
    }
}

?>
