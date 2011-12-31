<?php
### CLASSES ###
require_once( "classes/db.php" );

$db = new Db();
print_r( $db->query( "SELECT * FROM amministrazioni WHERE `nome`='Milano'" ) );

?>
