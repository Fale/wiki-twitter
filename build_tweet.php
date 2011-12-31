<?php
### CLASSES ###
require_once( "classes/divisioneamministrativa.php" );

$url = "http://it.wikipedia.org/w/api.php";
$a = new DivisioneAmministrativa( $url );
$a->getPage( "Divisione amministrativa" , "Milano" );
print_r( $a->tAll() );
$a->getPage( "Divisione amministrativa" , "Segrate" );
print_r( $a->tAll() );
$a->getPage( "Divisione amministrativa" , "Torino" );
print_r( $a->tAll() );
?>
