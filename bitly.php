<?php
require_once( "classes/bitly.php" );
require_once( "classes/db.php" );

$db = new Db;
$pages = $db->query( "SELECT * FROM itwp_pages WHERE short = ''" );
foreach( $pages as $page )
{
    print_r( $page );
    $r['ID'] = $page['ID'];
    $r['short'] = Bitly::shorten( $page['url'], 'fabiolocati','R_bf87ec63f9a0a974df98cebebdcb7b8d');
    $db->update( $r, "itwp_pages", "ID" );
    print_r( $r );
}
