<?php

require_once( "classes/botclasses.php" );
require_once( "settings/account.php" );

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
    preg_match_all( "/\<\!--[^-]*--\>/", $data, $ms, PREG_SET_ORDER );
    if( isset( $ms ) )
        foreach( $ms as $m )
            $data = str_replace( $m[0], "", $data );
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

$comuni = $wiki->whatusethetemplate( "Divisione amministrativa" );

$db = mysql_connect( $mysqlHost, $mysqlUser, $mysqlPass );
if ( !$db )
    die( "Could not connect: " . mysql_error() );
$db_selected = mysql_select_db( $mysqlDb, $db );
if ( !$db_selected )
    die ( "Can't use foo: " . mysql_error() );

foreach( $comuni as $comune )
{
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
    $q = substr( $q, 0, -2 ) . ";";

    $r = mysql_query( $q );
    if( !$r )
        die( "Invalid query: " . mysql_error() );
}
mysql_close();
?>
