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
            array_push( $a, "Anno" );
        if( $this->devel['1'] )
            array_push( $a, "Genere" );
        if( $this->devel['1'] )
            array_push( $a, "Tipo" );
        return $a;
    }

    public function pAll()
    {
        $a = Array();
        if( $this->devel['1'] )
            array_push( $a, trim( $this->pAnno( $s ) ) );
        if( $this->devel['1'] )
            array_push( $a, trim( $this->pGenere( $s ) ) );
        if( $this->devel['1'] )
            array_push( $a, trim( $this->pTipo( $s ) ) );
        return $a;
    }

    public function pTipo()
    {
        if( $this->array['Tipo album'] )
        {
            $tipi = Array( "studio", "singolo", "ep", "video", "raccolta", "compilation", "cover", "studio, live", "studio e live", "colonna sonora", "live", "vivo", "ep live", "video live", "video compilation", "video compilation live", "demo" );
            foreach( $tipi as $tipo)
                if( strtolower( $this->array['Tipo album'] ) == $tipo )
                    return "ok";
            return $this->array['Tipo album'];
        }
    }

    public function pAnno()
    {
        if( $this->array['Anno'] )
            if( preg_match( "/[0-9]{4}/", $this->array['Anno'] ) )
                return "ok";
            else
                return $this->array['Anno'];
    }

    public function pGenere()
    {
        if( $this->array['Genere'] )
            if( preg_match( "/[a-z]*/", $this->array['Genere'] ) )
                return "ok";
            else
                return $this->array['Genere'];
    }
}

?>
