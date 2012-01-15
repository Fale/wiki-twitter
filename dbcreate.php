<?php

require_once( "classes/botclasses.php" );
require_once( "classes/db.php" );

$wiki = new extended;
$wiki->url = 'http://it.wikipedia.org/w/api.php';
$db = new Db;

$template = "Divisione amministrativa";

$comuni = $wiki->whatusethetemplate( $template );
$tpl = $db->query( "SELECT * FROM itwp_templates WHERE `template`='$template'" );
$tpl = $tpl[0];
foreach( $comuni as $comune )
{
    $p['url'] = "http://it.wikipedia.org/wiki/" . $comune;
    $r['page'] = $db->smartinsert( $p, "itwp_pages", "url" );
    if( $r['page'] )
    {
	$r['template'] = $tpl['ID'];
	$db->insert( $r, "itwp_relations" );
    }
}
?>
