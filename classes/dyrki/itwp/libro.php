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
        array_push( $a, trim( $this->tGenere( $s ) ) );
        array_push( $a, trim( $this->tAnnoIta( $s ) ) );
        array_push( $a, trim( $this->tTipo( $s ) ) );
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

    public function tipo()
    {
        switch( $this->array['Tipo'] )
        {
            case "per adulti":
                $o = "#libro ";
                $this->array['Tipo'] = "per #adulti";
                break;
            case "fantascienza":
            case "Fantascienza":
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
            return "\"" . $this->array['Titolo'] . "\" è un" . ($this->array['Genere'] == "biografia" ? "a":"") . " #" . $this->array['Genere'] . ". #sapevatelo $s";
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
