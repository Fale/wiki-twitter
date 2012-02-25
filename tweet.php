<?php

### SETTINGS ###
require_once( "settings/app.php" );

### CLASSES ###
require_once( "classes/dyrki/dyrki.php" );
require_once( "classes/twitter/twitter.class.php" );
require_once( "classes/cli.php" );

$args = Cli::parseArgs($_SERVER['argv']);

$dyrki = new Dyrki( "1" );
$tweet = $dyrki->createTweets();

if( $args['send'] )
{
    $twitter = new Twitter( $twitterKey, $twitterSecret, $token, $secret );
    $t = $twitter->send( $out[array_rand( $out )] );
}
else
{
    print_r( $tweet );
    echo $tweet[array_rand( $tweet )] . "\n";
}
?>
