<?php
define( '__ROOT__', dirname( dirname( dirname( __FILE__ ) ) ) );
### CLASSES ###
require_once( __ROOT__ . "/classes/wiki/templateparser.php" );

class OperaArte extends TemplateParser
{
    public function tAll( $s )
    {
        $a = Array();
        if( $this->array['Titolo'] )
        {
            array_push( $a, trim( $this->tArtista( $s ) ) );
            array_push( $a, trim( $this->tMateriale( $s ) ) );
            array_push( $a, trim( $this->tTecnica( $s ) ) );
        }
        return array_filter( $a );
    }

    public function tTecnica( $s )
    {
        if( $this->array['Tecnica'] )
            return "\"" . $this->array['Titolo'] . "\" è un dipinto #" . $this->array['Tecnica'] . ". #sapevatelo $s";
    }

    public function tMateriale( $s )
    {
        if( $this->array['Materiale'] )
            return "\"" . $this->array['Titolo'] . "\" è una scultura in #" . $this->array['Materiale'] . ". #sapevatelo $s";
    }

    public function tArtista( $s )
    {
        if( $this->array['Artista'] )
            return "\"" . $this->array['Titolo'] . "\" è un'opera d'Arte di #" . $this->array['Artista'] . ". #sapevatelo $s";
    }
}
?>
