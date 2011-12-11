<?php

### SETTINGS ###
#require_once( "settings/db.php" );

### CLASSES ###
require_once( "classes/account.php" );

#Account::install();
$account = new Account( "1" );
$account->tweet();

?>
