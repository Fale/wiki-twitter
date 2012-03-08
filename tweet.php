<?php

### SETTINGS ###
require_once( "settings/app.php" );
require_once( "settings/db.php" );

### CLASSES ###
require_once( "classes/dyrki/dyrki.php" );
require_once( "classes/twitter/tmhOAuth.php" );
require_once( "classes/twitter/tmhUtilities.php" );
require_once( "classes/cli.php" );
require_once( "classes/db.php" );

$args = Cli::parseArgs($_SERVER['argv']);

if( ! $args['user'] )
    die( "Uso: tweet.php --user=# [--devel=#] [--send]\n" );

$dyrki = new Dyrki( $args['user'] );
$db = new Db();
$tweet = $dyrki->createTweets( $args['devel'] );
$tdata = $db->query( "SELECT * FROM accounts WHERE `ID` = " . $args['user'] . ";" );
if( $args['send'] )
{
    $twitter = new tmhOAuth( Array( 
        'consumer_key' => $twitterKey, 
        'consumer_secret' => $twitterSecret, 
        'user_token' => $tdata['0']['token'],
        'user_secret' => $tdata['0']['secret']
    ) );
    $t = $twitter->request( 'POST', $twitter->url( '1/statuses/update' ), Array( 'status' =>  $tweet[array_rand( $tweet )] ) );
    if( $code == 200 )
        tmhUtilities::pr( json_decode( $twitter->response['response'] ) );
    else
        tmhUtilities::pr( $twitter->response['response'] );
} else {
    print_r( $tweet );
    echo $tweet[array_rand( $tweet )] . "\n";
}
?>
