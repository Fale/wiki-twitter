<?php
require_once( "classes/bitly.php" );
require_once( "classes/db.php" );

$db = new Db;
$bitly = new Bitly( "o_247usnifoe", "R_bf87ec63f9a0a974df98cebebdcb7b8d");
$pages = $db->query( "SELECT * FROM itwp_pages WHERE short = '' OR short='INVALID_LOGIN' OR short='RATE_LIMIT_EXCEEDED'" );
foreach( $pages as $page )
{
    echo $page['url'] . " (" . $page['ID'] . ") ";
    $r['ID'] = $page['ID'];
    $r['short'] = $bitly->shorten( $page['url'] );
    echo "\033[00;32m[ OK ]\033[00m\n";
    if( $r['short'] == "INVALID_LOGIN" || $r['short'] == "RATE_LIMIT_EXCEEDED" )
        die();
    $db->update( $r, "itwp_pages", "ID" );
    usleep( 4 * 1000000 );
}
