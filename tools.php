<?php

require_once( "classes/wiki/botclasses.php" );
require_once( "classes/db.php" );
require_once( "classes/cli.php" );
require_once( "classes/dyrki/tools.php" );

$args = Cli::parseArgs($_SERVER['argv']);
$tools = new Tools();

$man = "Uso: php tools.php COMMAND [parameters]
    
COMMANDS:
  *pages                      manage pages
  *acount                     create account
  *follow                     follow user
";
    
switch( $args[0] )
{
    case "pages":
        if( !$args['source'] )
            die( "Uso: php tools.php pages --source=# [--template]\n" );
        else
            $tools->pages( $args );
        break;
    case "account":
        if( !$args['source'] )
            die( "Uso: php tools.php account --source=#\n" );
        else 
            $tools->account( $args );
        break;
    case "follow":
        if( !$args['1'] || !$args['2'] )
            die( "Uso: php tools.php follow USER_FOLLOWING USER_TO_FOLLOW\n" );
        else
            $tools->follow( $args );
        break;
    default:
        die( $man );
}
?>
