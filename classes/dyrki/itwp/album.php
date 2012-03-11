<?php
define( '__ROOT__', dirname( dirname( dirname( __FILE__ ) ) ) );
### CLASSES ###
require_once( __ROOT__ . "/classes/wiki/templateparser.php" );

class Album extends TemplateParser
{
    public function tAll( $s )
    {
        $a = Array();
        if( $this->devel['3'] )
            array_push( $a, trim( $this->tArtista( $s ) ) );
        if( $this->devel['1'] )
            array_push( $a, trim( $this->tAnno( $s ) ) );
        if( $this->devel['3'] )
            array_push( $a, trim( $this->tArtistaAnno( $s ) ) );
        if( $this->devel['1'] )
            array_push( $a, trim( $this->tGenere( $s ) ) );
        if( $this->devel['2'] )
            array_push( $a, trim( $this->tEtichetta( $s ) ) );
        return array_filter( $a );
    }

    public function tArtistaAnno( $s )
    {
        if( $this->array['Artista'] )
            return "\"" . $this->array['Titolo'] . "\" è un #album pubblicato nel #" . $this->array['Anno'] . " da #" . $this->array['Artista'] . ". #sapevatelo $s";
    }

    public function tGenere( $s )
    {
        if( $this->array['Genere'] )
            return "\"" . $this->array['Titolo'] . "\" è un #album di #musica #" . $this->array['Genere'] . ". #sapevatelo $s";
    }

    public function tEtichetta( $s )
    {
        if( $this->array['Etichetta'] && $this->array['Etichetta'] != "/" && $this->array['Etichetta'] != "-" )
            return "\"" . $this->array['Titolo'] . "\" è un #album distribuito da #" . $this->array['Etichetta'] . ". #sapevatelo $s";
    }

    public function tArtista( $s )
    {
        if( $this->array['Artista'] )
            return "\"" . $this->array['Titolo'] . "\" è un #album di #" . $this->array['Artista'] . ". #sapevatelo $s";
    }

    public function tAnno( $s )
    {
        if( $this->array['Anno'] )
            return "\"" . $this->array['Titolo'] . "\" è un #album pubblicato nel #" . $this->array['Anno'] . ". #sapevatelo $s";
    }
}

?>
