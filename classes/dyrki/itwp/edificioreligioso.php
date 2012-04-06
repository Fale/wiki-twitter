<?php
define( '__ROOT__', dirname( dirname( dirname( __FILE__ ) ) ) );
### CLASSES ###
require_once( __ROOT__ . "/classes/wiki/templateparser.php" );

class EdificioReligioso extends TemplateParser
{
    public function tAll( $s )
    {
        $a = Array();
        if( $this->array['Titolo'] )
        {
            if( $this->devel['3'] )
                array_push( $a, trim( $this->tCitta( $s ) ) );
            if( $this->devel['3'] )
                array_push( $a, trim( $this->tCostruzione( $s ) ) );
            if( $this->devel['3'] )
                array_push( $a, trim( $this->tConsacrazione( $s ) ) );
            if( $this->devel['3'] )
                array_push( $a, trim( $this->tStile( $s ) ) );
        }
        return array_filter( $a );
    }

    public function tCitta( $s )
    {
        if( $this->array['Città'] && $this->array['Nome'] && $this->array['Religione'] )
            return "\"" . $this->array['Nome'] . "\" è un edificio di religione #" . $this->array['Religione'] . " a #" . $this->array['Città'] . ". #sapevatelo $s";
    }

    public function tCostruzione( $s )
    {
        if( $this->array['Nome'] && $this->array['InizioCostr'] && $this->array['FineCostr'] )
            return "\"" . $this->array['Nome'] . "\" è stata costruita tra il " . $this->array['InizioCostr'] . " e il " . $this->array['FineCostr'] . ". #sapevatelo $s";
    }

    public function tConsacrazione( $s )
    {
        if( $this->array['Nome'] && $this->array['AnnoConsacr'] )
            return "\"" . $this->array['Nome'] . "\" è stata consacrata nel #" . $this->array['AnnoConsacr'] . ". #sapevatelo $s";
    }

    public function tStile( $s )
    {
        if( $this->array['StileArchitett'] && $this->array['Nome'] )
            return "\"" . $this->array['Nome'] . "\" è in stile #" . $this->array['StileArchitett'] . ". #sapevatelo $s";
    }
}
?>
