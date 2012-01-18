<?php

require_once( "classes/botclasses.php" );
require_once( "classes/db.php" );

$wiki = new extended;
$wiki->url = 'http://it.wikipedia.org/w/api.php';
$db = new Db;

$tpls = $db->query( "SELECT * FROM itwp_templates" );
foreach( $tpls as $tpl )
{
    $pages = $wiki->whatusethetemplate( $tpl['template'] );
    foreach( $pages as $page )
    {
        $p['url'] = "http://it.wikipedia.org/wiki/" . $page;
        $r['page'] = $db->smartinsert( $p, "itwp_pages", "url" );
        echo $r . "\n";
        if( $r['page'] )
        {
            $r['template'] = $tpl['ID'];
            $db->insert( $r, "itwp_relations" );
        }
    }
}
?>
