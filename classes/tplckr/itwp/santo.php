<?php
define( '__ROOT__', dirname( dirname( dirname( __FILE__ ) ) ) );
### CLASSES ###
require_once( __ROOT__ . "/classes/wiki/templateparser.php" );

class Santo extends TemplateParser
{
    public function pHead()
    {
        $a = Array();
        array_push( $a, "Pagina" );
        if( $this->devel['3'] )
            array_push( $a, "Venerato da" );
        return $a;
    }

    public function pAll()
    {
        $a = Array();
        if( $this->devel['1'] )
            array_push( $a, trim( $this->pVenerato( $s ) ) );
        return $a;
    }

    public function pVenerato()
    {
        if( $this->array['Venerato da'] )
        {
            $tipi = Array( "Tutte le Chiese che ammettono il culto dei santi", "Chiesa cattolica", "Chiese vetero-cattoliche", "Chiesa anglicana", "Chiesa cristiana ortodossa", "Chiesa ortodossa russa", "Vecchi Credenti", "Chiesa ortodossa serba", "Chiesa copta", "Chiese riformate", "Ebraismo", "Islam", "Buddhismo", "Taoismo", "Scintoismo", "Induismo" );
            foreach( $tipi as $tipo)
                if( $this->array['Venerato da'] == $tipo )
                    return "ok";
            return $this->array['Venerato da'];
        }
    }
}

?>
