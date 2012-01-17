<?php
### CLASSES ###
require_once( "classes/db.php" );
require_once( "classes/divisioneamministrativa.php" );

$db = new Db;
$url = "http://it.wikipedia.org/w/api.php";
$da = new DivisioneAmministrativa( $url );

$rows = $db->query( "SELECT * FROM itwp_pages ORDER BY RAND() LIMIT 10;");
foreach( $rows as $row )
{
    $da->getUrl( "Divisione amministrativa" , $row['url'] );
    print_r( $da->tAll() );
}
?>
