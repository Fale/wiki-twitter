<?php
define( '__ROOT__', dirname( dirname( dirname( __FILE__ ) ) ) );
### CLASSES ###
require_once( __ROOT__ . "/classes/wiki/templateparser.php" );

class Libro extends TemplateParser
{
    public function tAll( $s )
    {
        $a = Array();
        array_push( $a, trim( $this->tAutore( $s ) ) );
        array_push( $a, trim( $this->tAnno( $s ) ) );
        // Not yet stable
        //array_push( $a, trim( $this->tGenere( $s ) ) );
        array_push( $a, trim( $this->tAnnoIta( $s ) ) );
        array_push( $a, trim( $this->tTipo( $s ) ) );
        return array_filter( $a );
    }

    public function tipo()
    {
        switch( strtolower( $this->array['Tipo'] ) )
        {
            case "per adulti":
                $o = "#libro ";
                $this->array['Tipo'] = "per #adulti";
                break;
            case "fantascienza":
                $o = "#libro ";
                $this->array['Tipo'] = "#fantascientifico";
                break;
            case "per ragazzi":
                $o = "#libro ";
                $this->array['Tipo'] = "per #ragazzi";
                break;
            case "orrore":
                $o = "#libro dell'#";
                break;
            case "thriller":
                $o = "#libro #";
                break;
            case "saggio":
                $o = " #";
                break;
            default:
                $o = "#libro di tipo #";
                break;
        }
        return " " . $o . $this->array['Tipo'];
    }

    public function tAnnoIta( $s )
    {
        if( $this->array['Annoita'] )
            return "\"" . $this->array['Titolo'] . "\" è un #libro arrivato in #Italia nel #" . $this->array['Annoita'] . ". #sapevatelo $s";
    }

    public function tAnno( $s )
    {
        if( $this->array['Annoorig'] )
            return "\"" . $this->array['Titolo'] . "\" è un #libro del #" . $this->array['Annoorig'] . ". #sapevatelo $s";
    }

    public function tGenere( $s )
    {
        if( $this->array['Genere'] )
            return "\"" . $this->array['Titolo'] . "\" è un" . (strtolower($this->array['Genere']) == "biografia" ? "a":"") . " #" . strtolower( $this->array['Genere'] ) . ". #sapevatelo $s";
    }

    public function tAutore( $s )
    {
        if( $this->array['Autore'] )
            return "\"" . $this->array['Titolo'] . "\" è un #libro di #" . $this->array['Autore'] . ". #sapevatelo $s";
    }

    public function tTipo( $s )
    {
        if( $this->array['Tipo'] && $this->array['Tipo'] != "default" )
            return "\"" . $this->array['Titolo'] . "\" è un" . $this->tipo() . ". #sapevatelo $s";
    }
}

?>
