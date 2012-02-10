<?php
### CLASSES ###
require_once( "classes/db.php" );
require_once( "classes/tpltweet.php" );
require_once( "classes/bio.php" );
require_once( "classes/divisioneamministrativa.php" );
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
            case 2:
                $t = new DivisioneAmministrativa( $url );
                break;
            case 3:
                $t = new Bio( $url );
                break;
        }
        $t->getUrl( $tp[$tpid-1]['template'] , $row['url'] );
        $o = $t->tAll( $row['short'] );
        if( $o )
            $out = array_merge( $out, $o );
    }
}
//echo $out[array_rand( $out )] . "\n";
$ok = Array();
foreach( $out as $tw )
{
    if( strlen( $tw ) <= 140 )
        array_push( $ok, $tw );
}
print_r( $ok );
?>
