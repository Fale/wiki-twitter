<?php
define( '__ROOT__', dirname( dirname( dirname( __FILE__ ) ) ) );
echo __ROOT__;
### CLASSES ###
require_once( __ROOT__ . "/classes/wiki/templateparser.php" );

class DivisioneAmministrativa extends TemplateParser
{
    private $data = Array (
        "CHE" => Array (
            1 => Array(
                "grado" => "cantone",
                "gen" => "m",
                "amm" => "governo legislatore"
            ),
            2 => Array (
                "grado" => "distretto",
                "gen" => "m"
            ),
            3 => Array (
                "grado" => "comune",
                "gen" => "m",
                "amm" => "sindaco"
            ),
            4 => Array (
                "grado" => "frazione",
                "gen" => "f"
            ),
            5 => Array (
                "grado" => "quartiere",
                "gen" => "m"
            ),
            "f" => "svizzera",
            "m" => "svizzero"
        ),
        "FRA" => Array (
            1 => Array (
                "grado" => "regione",
                "gen" => "f",
                "amm" => "presidente"
            ),
            2 => Array (
                "grado" => "dipartimento",
                "gen" => "m",
                "amm" => "presidente"
            ),
            3 => Array (
                "grado" => "arrondissement",
                "gen" => "m",
            ),
            4 => Array (
                "grado" => "cantone",
                "gen" => "m"
            ),
            5 => Array (
                "grado" => "comune",
                "gen" => "m",
                "amm" => "sindaco"
            ),
            "f" => "francese",
            "m" => "francese"
        ),
        "ITA" => Array(
            1 => Array(
                "grado" => "regione",
                "gen" => "f",
                "amm" => "presidente"
            ),
            2 => Array (
                "grado" => "provincia",
                "gen" => "f",
                "amm" => "presidente"
            ),
            3 => Array (
                "grado" => "comune",
                "gen" => "m",
                "amm" => "sindaco"
            ),
            4 => Array(
                "grado" => "frazione",
                "gen" => "f"
            ),
            "f" => "italiana",
            "m" => "italiano"
        )
    );

    public function nazionalita()
    {
        if( $this->data[$this->array['Stato']] )
            switch( $this->data[$this->array['Stato']][$this->array['Grado amministrativo']]['gen'] )
            {
                case "f":
                    return $this->data[$this->array['Stato']]['f'];
                    break;
                case "m":
                    return $this->data[$this->array['Stato']]['m'];
                    break;
                default:
                    die( "Nazionalità" );
            }

    }

    public function grado()
    {
        if( $this->data[$this->array['Stato']] )
            switch( $this->data[$this->array['Stato']][$this->array['Grado amministrativo']]['gen'] )
            {
                case "f":
                    return "una #" . $this->data[$this->array['Stato']][$this->array['Grado amministrativo']]['grado'];
                    break;
                case "m":
                    return "un #" . $this->data[$this->array['Stato']][$this->array['Grado amministrativo']]['grado'];
                    break;
                default:
                    die( "Wrong grado:" . $this->array['Grado amministrativo'] );
            }
    }

    public function tAll( $s )
    {
        $a = Array();
        array_push( $a, trim( $this->tAbitanti( $s ) ) );
        array_push( $a, trim( $this->tSuperficie( $s ) ) );
        array_push( $a, trim( $this->tPatrono( $s ) ) );
        array_push( $a, trim( $this->tZonaSismica( $s ) ) );
        array_push( $a, trim( $this->tNomeAbitanti( $s ) ) );
        return array_filter( $a );
    }

    public function tAbitanti( $s )
    {
        if( $this->array['Abitanti'] && $this->grado() && $this->nazionalita() )
            return "#" . $this->array['Nome'] . " è " . $this->grado() . " #" . $this->nazionalita() . " di " . $this->array['Abitanti'] . " #abitanti. #sapevatelo $s";
    }

    public function tNomeAbitanti( $s )
    {
        if( $this->array['Nome abitanti'] )
            return "Gli #abitanti di #" . $this->array['Nome'] . " vengono chiamati #" . $this->array['Nome abitanti'] . ". #sapevatelo $s";
    }

    public function tZonaSismica( $s )
    {
        if( $this->array['Zona sismica'] )
            return "#" . $this->array['Nome'] . " è nella #zona #sismica " . $this->array['Zona sismica'] . ". #sapevatelo $s";
    }

    public function tPatrono( $s )
    {
        if( $this->array['Patrono'] )
            return "Il #santo #patrono di #" . $this->array['Nome'] . " è " . $this->array['Patrono'] . ". #sapevatelo $s";
    }

    public function tSuperficie( $s )
    {
        if( $this->array['Superficie'] && $this->grado() && $this->nazionalita() )
            return "#" . $this->array['Nome'] . " è " . $this->grado() . " #" . $this->nazionalita() . " di " . $this->array['Superficie'] . " #km². #sapevatelo $s";
    }
}

?>
