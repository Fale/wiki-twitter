<?php

### SETTINGS ###
require_once( "settings/app.php" );
require_once( "settings/db.php" );

### CLASSES ###
require_once( "classes/tplckr/tplckr.php" );
require_once( "classes/cli.php" );
require_once( "classes/db.php" );

$args = Cli::parseArgs($_SERVER['argv']);

if( ! $args['template'] )
    die( "Uso: tplckr.php --template=NAME [--devel=#]\n" );

$fp = fopen( "../public_html/" . $args['template'] . ".html", 'w');
$tplckr = new TplCkr( $args['template'] );
fwrite( $fp, $tplckr->checkTemplate( 1 ) );
fclose( $fp );
?>
