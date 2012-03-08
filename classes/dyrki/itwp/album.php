<?php
define( '__ROOT__', dirname( dirname( dirname( __FILE__ ) ) ) );
### CLASSES ###
require_once( __ROOT__ . "/classes/wiki/templateparser.php" );

class Album extends TemplateParser
{
    public function tAll( $s )
    {
        $a = Array();
        array_push( $a, trim( $this->tArtista( $s ) ) );
        array_push( $a, trim( $this->tAnno( $s ) ) );
        array_push( $a, trim( $this->tArtistaAnno( $s ) ) );
        array_push( $a, trim( $this->tGenere( $s ) ) );
        return array_filter( $a );
    }

    public function tArtistaAnno( $s )
    {
        if( $this->array['Artista'] )
            return "\"" . $this->array['Titolo'] . "\" è un album pubblicato nel #" . $this->array['Anno'] . " da #" . $this->array['Artista'] . ". #sapevatelo $s";
    }

    public function tGenere( $s )
    {
        if( $this->array['Genere'] )
            return "\"" . $this->array['Titolo'] . "\" è un album #" . $this->array['Genere'] . ". #sapevatelo $s";
    }

    public function tArtista( $s )
    {
        if( $this->array['Artista'] )
            return "\"" . $this->array['Titolo'] . "\" è un album di #" . $this->array['Artista'] . ". #sapevatelo $s";
    }

    public function tAnno( $s )
    {
        if( $this->array['Anno'] )
            return "\"" . $this->array['Titolo'] . "\" è un album pubblicato nel #" . $this->array['Anno'] . ". #sapevatelo $s";
    }
}

?>
