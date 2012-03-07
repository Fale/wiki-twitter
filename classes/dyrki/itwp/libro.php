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
            case "giallo":
                $o = " #";
                break;
            case "saggio":
                $o = " #";
                break;
            default:
                $o = "libro di #";
                break;
        }
        return $o . $this->array['Tipo'];
    }

    public function tAutore( $s )
    {
        if( $this->array['Autore'] )
            return "\"" . $this->array['Titolo'] . "\" è un libro di #" . $this->array['Autore'] . ". #sapevatelo $s";
    }

    public function tTipo( $s )
    {
        if( $this->array['Tipo'] )
            return "\"" . $this->array['Titolo'] . "\" è un" . $this->tipo() . ". #sapevatelo $s";
    }
}

?>
