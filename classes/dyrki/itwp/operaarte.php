<?php
define( '__ROOT__', dirname( dirname( dirname( __FILE__ ) ) ) );
### CLASSES ###
require_once( __ROOT__ . "/classes/wiki/templateparser.php" );

class OperaArte extends TemplateParser
{

    private function opera()
    {
        if( strtolower( $this->array['Opera'] ) == "scultura" )
            return "una #sclutura";
        if( strtolower( $this->array['Opera'] ) == "dipinto" )
            return "un #dipinto";
    }

    public function tAll( $s )
    {
        $a = Array();
        if( $this->array['Titolo'] )
        {
            if( $this->devel['1'] )
                array_push( $a, trim( $this->tArtista( $s ) ) );
            if( $this->devel['1'] )
                array_push( $a, trim( $this->tMateriale( $s ) ) );
            if( $this->devel['3'] )
                array_push( $a, trim( $this->tTecnica( $s ) ) );
            if( $this->devel['1'] )
                array_push( $a, trim( $this->tAltezza( $s ) ) );
        }
        return array_filter( $a );
    }

    public function tTecnica( $s )
    {
        if( $this->array['Tecnica'] )
            return "\"" . $this->array['Titolo'] . "\" è un dipinto #" . $this->array['Tecnica'] . ". #sapevatelo $s";
    }

    public function tAltezza( $s )
    {
        if( $this->array['Altezza'] )
            return "\"" . $this->array['Titolo'] . "\" è " . $this->opera() . " alt" . ($this->array['Opera'] == "dipinto" ? "o":"a") . " " . $this->array['Altezza'] . " #cm. #sapevatelo $s";
    }

    public function tMateriale( $s )
    {
        if( $this->array['Materiale'] )
            return "\"" . $this->array['Titolo'] . "\" è una scultura in #" . $this->array['Materiale'] . ". #sapevatelo $s";
    }

    public function tArtista( $s )
    {
        if( $this->array['Artista'] )
            return "\"" . $this->array['Titolo'] . "\" è " . $this->opera() . " di #" . $this->array['Artista'] . ". #sapevatelo $s";
    }
}
?>
