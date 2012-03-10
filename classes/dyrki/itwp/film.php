<?php
define( '__ROOT__', dirname( dirname( dirname( __FILE__ ) ) ) );
### CLASSES ###
require_once( __ROOT__ . "/classes/wiki/templateparser.php" );

class Film extends TemplateParser
{
    public function tAll( $s )
    {
        if( $this->array['Titoloitaliano'] )
        {
            $a = Array();
            if( $this->devel['1'] )
                array_push( $a, trim( $this->tAnno( $s ) ) );
            if( $this->devel['1'] )
                array_push( $a, trim( $this->tGenere( $s ) ) );
            if( $this->devel['1'] )
                array_push( $a, trim( $this->tDurata( $s ) ) );
            if( $this->devel['1'] )
                array_push( $a, trim( $this->tRegista( $s ) ) );
            if( $this->devel['1'] )
                $a = array_merge( $a, $this->tAttori( $s ) );
            return array_filter( $a );
        }
    }

    public function tAnno( $s )
    {
        if( $this->array['Annouscita'] )
            return "\"" . $this->array['Titoloitaliano'] . "\" è un #film del #" . $this->array['Annouscita'] . ". #sapevatelo $s";
    }

    public function tGenere( $s )
    {
        if( $this->array['Genere'] )
            return "\"" . $this->array['Titoloitaliano'] . "\" è un #film #" . $this->array['Genere'] . ". #sapevatelo $s";
    }

    public function tDurata( $s )
    {
        if( $this->array['Durata'] )
            return "La #durata del #film \"" . $this->array['Titoloitaliano'] . "\" è di #" . $this->array['Durata'] . ". #sapevatelo $s";
    }

    public function tRegista( $s )
    {
        if( $this->array['Regista'] )
            if( preg_match( "/,/i", $this->array['Regista'] ) || preg_match( "/ e /i", $this->array['Regista'] ) )
                return "I #registi del #film \"" . $this->array['Titoloitaliano'] . "\" sono " . $this->array['Regista'] . ". #sapevatelo $s";
            else
                return "Il #regista del #film \"" . $this->array['Titoloitaliano'] . "\" è " . $this->array['Regista'] . ". #sapevatelo $s";
    }

    public function tAttori( $s )
    {
        $out = Array();
        if( $this->array['Attori'] )
        {
            $attori = explode( "*", $this->array['Attori'] );
            foreach( $attori as $attore )
            {
                preg_match( "/(.*):(.*)/i", $attore, $m );
                if( $m[1] && $m[2] )
                {
                    $o = trim( $m[1] ) . " ha #interpretato " . trim( $m[2] ) . " nel #film \"" . $this->array['Titoloitaliano'] . "\". #sapevatelo $s";
                    array_push( $out, trim( $o ) );
                }
            }
        }
        return $out;
    }
}

?>
