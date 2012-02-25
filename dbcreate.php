<?php

require_once( "classes/wiki/botclasses.php" );
require_once( "classes/db.php" );
require_once( "classes/cli.php" );

function pages( $args )
{
    $db = new Db;
    $src = $db->query( "SELECT * FROM `sources` WHERE `ID_source` = '" . $args['source'] . "';" );
    $prefix = $src['0']['prefix'];
    $apiurl = $src['0']['apiurl'];
    $url = $src['0']['url'];
    $wiki = new extended( $apiurl );

    if( $args['template'] )
        $where = " AND `template` = '" . $args['template'] . "';";
    else
        $where = ";";

    $tpls = $db->query( "SELECT * FROM templates WHERE `ID_source` = " . $args['source'] . $where );
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
}

$args = Cli::parseArgs($_SERVER['argv']);
if( $args[0] == "pages" )
    if( !$args['source'] )
        die( "Uso: dbcreate.php pages --source=# [--template]\n" );
    else
        pages( $args );
else
    die( "Uso: dbcreate COMMAND [parameters]\nCOMMANDS:\n*pages\tmanage pages" );
?>
