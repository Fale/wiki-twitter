<?php
### CLASSES ###
require_once( "classes/tweets.php" );

$account = new Tweets( "1" );
$account->tweet(1);
?>
