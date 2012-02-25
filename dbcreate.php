<?php

require_once( "classes/wiki/botclasses.php" );
require_once( "classes/db.php" );
require_once( "classes/cli.php" );

$args = Cli::parseArgs($_SERVER['argv']);
if( ! $args['source'] )
        die( "Uso: tweet.php --source=# [--template]\n" );

$db = new Db;
$src = $db->query( "SELECT * FROM `sources` WHERE `ID_source` = '" . $args['source'] . "';" );
$prefix = $src['0']['prefix'];
$apiurl = $src['0']['apiurl'];
$url = $src['0']['url'];
$wiki = new extended( $apiurl );

if( $args['template'] )
    $where = " WHERE `template` = '" . $args['tpl'] . "';";
else
    $where = ";";

$tpls = $db->query( "SELECT * FROM " . $prefix . "_templates" . $where );
foreach( $tpls as $tpl )
{
    $pages = $wiki->whatusethetemplate( $tpl['template'] );
    foreach( $pages as $page )
    {
        $p['url'] = $url . $page;
        $r['page'] = $db->smartinsert( $p, $prefix . "_pages", "url" );
        echo $p['url'] . " (Tpl:" . $tpl['template'] . ") (ID:" . $r['page'] . ")\n";
        if( $r['page'] )
        {
            $r['template'] = $tpl['ID'];
            $db->insert( $r, $prefix . "_relations" );
        }
    }
}
?>
