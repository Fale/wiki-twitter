<?php

### SETTINGS ###
require_once( "settings/app.php" );
require_once( "settings/db.php" );

### CLASSES ###
require_once( "classes/db.php" );
require_once( "classes/tpltweet.php" );
require_once( "classes/bio.php" );
require_once( "classes/film.php" );
require_once( "classes/divisioneamministrativa.php" );
require_once( "classes/twitter/twitter.class.php" );
require_once( "classes/cli.php" );

$args = Cli::parseArgs($_SERVER['argv']);
$db = new Db;
$url = "http://it.wikipedia.org/w/api.php";
$tp = $db->query( "SELECT * FROM itwp_templates;" );
$rows = $db->query( "SELECT ID, url, short FROM itwp_pages ORDER BY RAND() LIMIT 10;" );
$out = Array();
foreach( $rows as $row )
{
    if( $row['short'] )
    {
        $tpl = $db->query( "SELECT `template` FROM itwp_relations WHERE `page` = " . $row['ID'] );
        $tpid = $tpl['0']['template'];
        switch( $tpid )
        {
/*            case 2:
                $t = new DivisioneAmministrativa( $url );
                break;
            case 3:
                $t = new Bio( $url );
                break;
*/            case 4:
                $t = new Film( $url );
                break;
        }
        if( $t )
        {
            $t->getUrl( $tp[$tpid-1]['template'] , $row['url'] );
            $o = $t->tAll( $row['short'] );
            if( $o )
                $out = array_merge( $out, $o );
        }
    }
}

$ok = Array();
foreach( $out as $tw )
{
    if( strlen( $tw ) <= 140 )
        array_push( $ok, $tw );
}

//print_r( $ok );

$db = mysql_connect( $mysqlHost, $mysqlUser, $mysqlPass );
if ( !$db )
    die( "Could not connect: " . mysql_error() );
$db_selected = mysql_select_db( $mysqlDb, $db );
if ( !$db_selected )
    die ( "Can't use foo: " . mysql_error() );

$r = mysql_query( "SELECT * FROM accounts WHERE ID=1", $db );
if ( !$r )
    die( "Invalid query: " . mysql_error() );
$row = mysql_fetch_assoc( $r );
$token = $row['token'];
$secret = $row['secret'];

if( $args['send'] )
{
    $twitter = new Twitter( $twitterKey, $twitterSecret, $token, $secret );
    $t = $twitter->send( $out[array_rand( $out )] );
}
else
{
    print_r( $out );
    echo $out[array_rand( $out )] . "\n";
}
?>
