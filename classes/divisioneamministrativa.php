<?php
require_once( "templateparser.php" );

class DivisioneAmministrativa extends TemplateParser
{
    public function grado()
    {
        if( $this->array['Stato'] == "ITA" )
            switch( $this->array['Grado amministrativo'] )
            {
                case "1":
                    return "una #regione";
                case "2":
                    return "una #provincia";
                case "3":
                    return "un #comune";
                    break;
                default:
                    die( "Wrong grado" );
            }
    }

    public function tAll()
    {
        $a = Array();
        array_push( $a, $this->tAbitanti() );
        array_push( $a, $this->tSuperficie() );
        array_push( $a, $this->tPatrono() );
        array_push( $a, $this->tZonaSismica() );
        array_push( $a, $this->tNomeAbitanti() );
        return $a;
    }

    public function tAbitanti()
    {
        return "#" . $this->array['Nome'] . " è " . $this->grado() . " di " . $this->array['Abitanti'] . " #abitanti.";
    }

    public function tNomeAbitanti()
    {
        return "Gli abitanti di #" . $this->array['Nome'] . " vengono chiamati " . $this->array['Nome abitanti'] . ".";
    }

    public function tZonaSismica()
    {
        return "#" . $this->array['Nome'] . " è nella zona sismica " . $this->array['Zona sismica'] . ".";
    }

    public function tPatrono()
    {
        return "Il santo patrono di #" . $this->array['Nome'] . " è " . $this->array['Patrono'] . ".";
    }

    public function tSuperficie()
    {
        return "#" . $this->array['Nome'] . " è " . $this->grado() . " di " . $this->array['Superficie'] . " #km².";
    }
}

?>