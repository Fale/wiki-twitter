<?php

class datiGeografici
{
    private $wiki;

    private $regioni = Array( 
        "Categoria:Comuni dell'Abruzzo", 
        "Categoria:Comuni della Basilicata", 
        "Categoria:Comuni della Calabria", 
        "Categoria:Comuni della Campania", 
        "Categoria:Comuni dell'Emilia-Romagna", 
        "Categoria:Comuni del Friuli-Venezia Giulia", 
        "Categoria:Comuni del Lazio", 
        "Categoria:Comuni della Liguria", 
        "Categoria:Comuni della Lombardia", 
        "Categoria:Comuni delle Marche", 
        "Categoria:Comuni del Molise", 
        "Categoria:Comuni del Piemonte", 
        "Categoria:Comuni della Puglia", 
        "Categoria:Comuni della Sardegna", 
        "Categoria:Comuni della Sicilia", 
        "Categoria:Comuni della Toscana", 
        "Categoria:Comuni del Trentino-Alto Adige", 
        "Categoria:Comuni dell'Umbria", 
        "Categoria:Comuni della Valle d'Aosta", 
        "Categoria:Comuni del Veneto" 
    );

    public function __construct()
    {
        $this->wiki = new wikipedia;
        $this->wiki->url = 'http://it.wikipedia.org/w/api.php';
    }

    public function get_province_all()
    {
        $province = Array( "Categoria:Comuni della Valle d'Aosta" );
        foreach( $regioni as $regione )
            array_push( $province, $this->get_province( $regione ) );
        return $province;
    }

    public function get_province( $regione )
    {
        $members = $this->wiki->categorymembers( $regione );
        foreach ( $members as $member )
            if( substr( $member, 0, 32 ) == "Categoria:Comuni della provincia" )
                return $member;
    }

    public function get_comuni_all()
    {
        $pages = Array();
        foreach( $province as $provincia )
            array_push( $pages, $this->get_comuni( $provincia ) );
        return $pages;
    }

    public function get_comuni( $provincia )
    {
        $members = $this->wiki->categorymembers( $provincia );
        $pages = Array();
        foreach ( $members as $member )
            if( substr( $member, 0, 10 ) != "Categoria:" )
                array_push( $pages, $member );
        return $pages;
    }
}

?>