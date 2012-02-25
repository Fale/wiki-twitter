<?php

### SETTINGS ###
require_once( "settings/app.php" );
require_once( "settings/db.php" );

### CLASSES ###
require_once( "classes/dyrki/dyrki.php" );
require_once( "classes/twitter/twitter.class.php" );
require_once( "classes/cli.php" );
require_once( "classes/db.php" );

$args = Cli::parseArgs($_SERVER['argv']);

if( ! $args['user'] )
    die( "Uso: tweet.php --user=# [--send]\n" );

$dyrki = new Dyrki( $args['user'] );
$db = new Db();
$tweet = $dyrki->createTweets();
$tdata = $db->query( "SELECT * FROM accounts WHERE `ID` = " . $args['user'] . ";" );
if( $args['send'] )
{
    $twitter = new Twitter( $twitterKey, $twitterSecret, $tdata['0']['token'], $tdata['0']['secret'] );
    $t = $twitter->send( $tweet[array_rand( $tweet )] );
}
else
{
    print_r( $tweet );
    echo $tweet[array_rand( $tweet )] . "\n";
}
?>
