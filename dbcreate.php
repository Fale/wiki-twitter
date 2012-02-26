<?php

require_once( "classes/wiki/botclasses.php" );
require_once( "classes/db.php" );
require_once( "classes/cli.php" );
require_once( "classes/dyrki/tools.php" );

$args = Cli::parseArgs($_SERVER['argv']);
$tools = new Tools();

switch( $args[0] )
{
    case "pages":
        if( !$args['source'] )
            die( "Uso: dbcreate.php pages --source=# [--template]\n" );
        else
            $tools->pages( $args );
        break;
    case "account":
        if( !$args['source'] )
            die( "Uso: dbcreate.php account --source=#\n" );
        else 
            $tools->account( $args );
    default:
        die( "Uso: dbcreate COMMAND [parameters]\nCOMMANDS:\n*pages\t\t\tmanage pages\n*acount\t\t\tcreate account\n" );
}
?>
