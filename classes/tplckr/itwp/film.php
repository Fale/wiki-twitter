<?php
define( '__ROOT__', dirname( dirname( dirname( __FILE__ ) ) ) );
### CLASSES ###
require_once( __ROOT__ . "/classes/wiki/templateparser.php" );

class Album extends TemplateParser
{
    public function pHead()
    {
        $a = Array();
        array_push( $a, "Pagina" );
        if( $this->devel['1'] )
            array_push( $a, "Annouscita" );
        if( $this->devel['1'] )
            array_push( $a, "Durata" );
        if( $this->devel['1'] )
            array_push( $a, "Tipoaudio" );
        if( $this->devel['1'] )
            array_push( $a, "Tipocolore" );
        return $a;
    }

    public function pAll()
    {
        $a = Array();
        if( $this->devel['1'] )
            array_push( $a, trim( $this->pAnnouscita( $s ) ) );
        if( $this->devel['1'] )
            array_push( $a, trim( $this->pDurata( $s ) ) );
        if( $this->devel['1'] )
            array_push( $a, trim( $this->pTipoaudio( $s ) ) );
        if( $this->devel['1'] )
            array_push( $a, trim( $this->pTipocolore( $s ) ) );
        return $a;
    }

    public function pAnnouscita()
    {
        if( $this->array['Annouscita'] )
            if( preg_match( "/\[\[[0-9]{4}\]\]/", $this->array['Annouscita'] ) )
                return "ok";
            else
                return $this->array['Annouscita'];
    }

    public function pDurata()
    {
        if( $this->array['Durata'] )
            if( preg_match( "/[0-9]+ min/", $this->array['Durata'] ) )
                return "ok";
            else
                return $this->array['Durata'];
    }

    public function pTipoaudio()
    {
        if( $this->array['Tipoaudio'] )
            if( trim( $this->array['Tipoaudio'] )  == "muto" || trim( $this->array['Tipoaudio'] ) == "sonoro" )
                return "ok";
            else
                return $this->array['Tipoaudio'];
    }

    public function pTipocolore()
    {
        if( $this->array['Tipocolore'] )
            if( trim( $this->array['Tipocolore'] )  == "colore" || trim( $this->array['Tipocolore'] ) == "B/N" )
                return "ok";
            else
                return $this->array['Tipocolore'];
    }
}

?>
