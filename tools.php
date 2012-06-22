<?php

require_once( "classes/wiki/botclasses.php" );
require_once( "classes/db.php" );
require_once( "classes/cli.php" );
require_once( "classes/dyrki/tools.php" );

$args = Cli::parseArgs($_SERVER['argv']);
$tools = new Tools();

$man = "Uso: php tools.php COMMAND [parameters]
    
COMMANDS:
 -account                   create account
 -getTweets                 get tweet for a precise user
 -follow                    follow user
 -pages                     manage pages
 *account add               add an account
 *account list              list all accounts
 *account follow            follow some user with a twitter account
  source add                add a source
 *source list               list all sources
 *source populate           populate with articles the pages table
  template add              add a template
 *template list             list all templates
 *template populate         populate with articles the pages table
";
    
switch( $args[0] )
{
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
    case "pages":
        if( !$args['source'] )
            die( "Uso: php tools.php pages --source=# [--template]\n" );
        else
            $tools->pages( $args );
        break;
    case "getTweets":
        if( !$args['source'] )
            die( "Uso: php tools.php getTweets --source=#\n" );
        else
            $tools->getTweets( $args );
        break;
    case "source":
        if( $args['1'] == "add" )
            if( !$args['prefix'] || !$args['url'] || !$args['apiurl'] )
                die( "Uso: php tools.php source add --prefix=PREFIX --url=URL --apiurl=APIURL [--auto-follow]\n" );
            else
                $tools->source( $args );
        else
            die( "Uso: php tools.php source add --prefix=PREFIX --url=URL --apiurl=APIURL [--auto-follow]\n" );
        break;
    case "template":
        if( $args['1'] == "add" )
            if( !$args['template'] || !$args['function'] || !$args['source'] )
                die( "Uso: php tools.php template add --template=TPL_NAME --function=FCT_NAME --source=SOURCE_ID\n" );
            else
                $tools->template( $args );
        else
            die( "Uso: php tools.php template add --template=TPL_NAME --function=FCT_NAME --source=SOURCE_ID\n" );
        break;
    default:
        die( $man );
}
?>
