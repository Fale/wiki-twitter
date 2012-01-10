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
    $db->smartinsert( $p, "itwp_divamm", "url" );
}
?>
