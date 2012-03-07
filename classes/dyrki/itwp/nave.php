<?php
define( '__ROOT__', dirname( dirname( dirname( __FILE__ ) ) ) );
### CLASSES ###
require_once( __ROOT__ . "/classes/wiki/templateparser.php" );

class Nave extends TemplateParser
{
    public function tAll( $s )
    {
        $a = Array();
        array_push( $a, trim( $this->tClasse( $s ) ) );
        array_push( $a, trim( $this->tOperatore( $s ) ) );
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
    
    public function tTipo( $s )
    {
        if( $this->array['Tipo'] )
            return $this->array['Nome'] . " è una " . $this->array['Tipo'] . ". #sapevatelo $s";
    }

    public function tOperatore( $s )
    {
        if( $this->array['Operatore'] )
            return $this->array['Nome'] . " è una nave di " . $this->array['Operatore'] . ". #sapevatelo $s";
    }

    public function tClasse( $s )
    {
        if( $this->array['Classe'] )
            return $this->array['Nome'] . " è una nave di classe " . $this->array['Classe'] . ". #sapevatelo $s";
    }
}

?>