<?php

require_once( "botclasses.php" );

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

function clean( $data )
{
    preg_match_all( "/\[\[([^\|\]]+)[\|]?([^\|\]]*)\]\]/", $data, $matches, PREG_SET_ORDER );
    if( isset( $matches ) )
        foreach( $matches as $match )
        {
            if( $match[2] )
                $ok = $match[2];
            else
                $ok = $match[1];
            $data = str_replace( $match[0], $ok, $data );
        }
    return $data;
}

function parse( $data, $string, $clean = 1 )
{
    preg_match( "/\|" . $string . "=(.*)/i", $data, $matches );
    if( isset( $matches[1] ) )
        if( !$clean )
            return $matches[1];
        else
            return clean( $matches[1] );
    else
        return NULL;
}

$wiki = new extended;
$wiki->url = 'http://it.wikipedia.org/w/api.php';

/*$dati = new datiGeografici;
$comuni = $dati->get_comuni( "Categoria:Comuni della provincia di Milano" );

foreach( $comuni as $comune )
*/
{
    $comune = "Abbiategrasso";
    $data = $wiki->gettemplate( $comune, "Divisione amministrativa" );
    $p['url'] = "http://it.wikipedia.org/wiki/" . $comune;
    $p['nome'] = parse( $data, "Nome" );
    $p['stato'] = parse( $data, "Stato" );
    $p['grado'] = parse( $data, "Grado amministrativo" );
    $p['grado1'] = parse( $data, "Divisione amm grado 1" );
    $p['grado2'] = parse( $data, "Divisione amm grado 2" );
    $p['grado3'] = parse( $data, "Divisione amm grado 3" );
    $p['grado4'] = parse( $data, "Divisione amm grado 4" );
    $p['capoluogo'] = parse( $data, "Capoluogo" );
    $p['amministrazione'] = parse( $data, "Amministrazione locale" );
    $p['partito'] = parse( $data, "Partito" );
    $p['elezione'] = parse( $data, "Data elezione" );
    $p['lingue'] = parse( $data, "Lingue ufficiali" );
    $p['istituzione'] = parse( $data, "Data istituzione" );
    $p['soppressione'] = parse( $data, "Data soppressione" );
    $p['latitudine'] = parse( $data, "Latitudine decimale" );
    $p['longitudine'] = parse( $data, "Longitudine decimale" );
    $p['latitudine_gradi'] = parse( $data, "Latitudine gradi" );
    $p['latitudine_minuti'] = parse( $data, "Latitudine minuti" );
    $p['latitudine_secondi'] = parse( $data, "Latitudine secondi" );
    $p['latitudine_ns'] = parse( $data, "Latitudine NS" );
    $p['longitudine_gradi'] = parse( $data, "Longitudine gradi" );
    $p['longitudine_minuti'] = parse( $data, "Longitudine minuti" );
    $p['longitudine_secondi'] = parse( $data, "Longitudine secondi" );
    $p['longitudine_ew'] = parse( $data, "Longitudine EW" );
    $p['altitudine'] = parse( $data, "Altitudine" );
    $p['superficie'] = parse( $data, "Superficie" );
    $p['abitanti'] = parse( $data, "Abitanti" );
    $p['sottodivisioni'] = parse( $data, "Sottodivisioni" );
    $p['divisioni_confinanti'] = parse( $data, "Divisioni confinanti" );
    $p['lingue'] = parse( $data, "Lingue" );
    $p['cap'] = parse( $data, "Codice Postale" );
    $p['prefisso'] = parse( $data, "Prefisso" );
    $p['fuso'] = parse( $data, "Fuso orario" );
    $p['iso'] = parse( $data, "Codice ISO" );
    $p['codice_statistico'] = parse( $data, "Codice statistico" );
    $p['codice_catastale'] = parse( $data, "Codice catastale" );
    $p['targa'] = parse( $data, "Targa" );
    $p['zona_sismica'] = parse( $data, "Zona sismica" );
    $p['gradi_giorno'] = parse( $data, "Gradi giorno" );
    $p['diffusivita'] = parse( $data, "Diffusività" );
    $p['nome_abitanti'] = parse( $data, "Nome abitanti" );
    $p['patrono'] = parse( $data, "Patrono" );
    $p['festivo'] = parse( $data, "Festivo" );
    $p['pil'] = parse( $data, "PIL" );
    $p['pil_procapite'] = parse( $data, "PIL procapite" );
    $p['pil_ppa'] = parse( $data, "PIL PPA" );
    $p['pil_procapite_ppa'] = parse( $data, "PIL procapite PPA" );
    $p['parlamentari'] = parse( $data, "Parlamentari" );

    $q = "REPLACE INTO `amministrazioni` SET ";
    foreach( $p as $k => $v )
        $q.= "`" . $k . "` = '" . mysql_escape_string( $v ) . "', "; 
    echo $q;

    $mysqlHost = "localhost";
    $mysqlUser = "wt";
    $mysqlPass = "c00f9dbd";
    $mysqlDb = "wt_main";
    $db = mysql_connect( $mysqlHost, $mysqlUser, $mysqlPass );
    if ( !$db )
        die( "Could not connect: " . mysql_error() );
    $db_selected = mysql_select_db( $mysqlDb, $db );
    if ( !$db_selected )
        die ( "Can't use foo: " . mysql_error() );
    $r = mysql_query( $q );
    if( !$r )
        die( "Invalid query: " . mysql_error() );

}
?>
