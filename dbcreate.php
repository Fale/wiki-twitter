<?php

require_once( "classes/botclasses.php" );
require_once( "classes/db.php" );
require_once( "classes/cli.php" );

$args = Cli::parseArgs($_SERVER['argv']);

$wiki = new extended;
$wiki->url = 'http://it.wikipedia.org/w/api.php';
$db = new Db;

if( $args['tpl'] )
    $where = " WHERE `template` = '" . $args['tpl'] . "';";
else
    $where = ";";
$tpls = $db->query( "SELECT * FROM itwp_templates" . $where );
foreach( $tpls as $tpl )
{
    $pages = $wiki->whatusethetemplate( $tpl['template'] );
    foreach( $pages as $page )
    {
        $p['url'] = "http://it.wikipedia.org/wiki/" . $page;
        $r['page'] = $db->smartinsert( $p, "itwp_pages", "url" );
        echo $p['url'] . " (Tpl:" . $tpl['template'] . ") (ID:" . $r['page'] . ")\n";
        if( $r['page'] )
        {
            $r['template'] = $tpl['ID'];
            $db->insert( $r, "itwp_relations" );
        }
    }
}
?>
