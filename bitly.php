<?php
require_once( "classes/bitly.php" );
require_once( "classes/db.php" );

$db = new Db;
$pages = $db->query( "SELECT * FROM itwp_pages WHERE short = ''" );
foreach( $pages as $page )
    print_r( $page );
if( $a == 12 )
    $short_url = Bitly::short('','fabiolocati','R_bf87ec63f9a0a974df98cebebdcb7b8d');

