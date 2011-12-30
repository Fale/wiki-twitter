<?php

$mysqlHost = "localhost";
$mysqlUser = "wt";
$mysqlPass = "c00f9dbd";
$mysqlDb = "wt_main";
$db = mysql_connect( $mysqlHost, $mysqlUser, $mysqlPass );
if ( !$db )
    die( "Could not connect: " . mysql_error() );
$db_selected = mysql_select_db( $mysqlDb, $db );
if ( !$db_selected )
    die ( "Can't use foo: " . mysql_error() );

$r = mysql_query( "SELECT * FROM amministrazioni WHERE nome='Arconate' LIMIT 1" );
if( !$r )
    die( "Invalid query: " . mysql_error() );
print_r( mysql_fetch_assoc( $r ) );


?>
