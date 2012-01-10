<?php

require_once( "classes/botclasses.php" );
require_once( "classes/db.php" );

$wiki = new extended;
$wiki->url = 'http://it.wikipedia.org/w/api.php';
$db = new Db;

$comuni = $wiki->whatusethetemplate( "Divisione amministrativa" );

foreach( $comuni as $comune )
{
    $p['url'] = "http://it.wikipedia.org/wiki/" . $comune;



    $r = mysql_query( $q );
    if( !$r )
        die( "Invalid query: " . mysql_error() );
}
mysql_close();
?>
