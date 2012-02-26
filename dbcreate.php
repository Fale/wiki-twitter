<?php

require_once( "classes/wiki/botclasses.php" );
require_once( "classes/db.php" );
require_once( "classes/cli.php" );

function pages( $args )
{
    $db = new Db;
    $src = $db->query( "SELECT * FROM `sources` WHERE `ID_source` = '" . $args['source'] . "';" );
    $prefix = $src['0']['prefix'];
    $apiurl = $src['0']['apiurl'];
    $wiki = new extended( $apiurl );

    if( $args['template'] )
        $where = " AND `template` = '" . $args['template'] . "';";
    else
        $where = ";";

    $tpls = $db->query( "SELECT * FROM templates WHERE `ID_source` = " . $args['source'] . $where );
    foreach( $tpls as $tpl )
    {
        $pages = $wiki->whatusethetemplate( $tpl['template'] );
        foreach( $pages as $page )
        {
            $p['url'] = $page;
            $r['page'] = $db->smartinsert( $p, $prefix . "_pages", "url" );
            echo $p['url'] . " (Tpl:" . $tpl['template'] . ") (ID:" . $r['page'] . ")\n";
            if( $r['page'] )
            {
                $r['template'] = $tpl['ID'];
                $db->insert( $r, $prefix . "_relations" );
            }
        }
    }
}

function request_token($twitter)
{
    $code = $twitter->request('POST', $twitter->url('oauth/request_token', ''), array( 'oauth_callback' => 'oob' ));
    if ($code == 200)
    {
        $oauth_creds = $twitter->extract_params($twitter->response['response']);
        $twitter->config['user_token']  = $oauth_creds['oauth_token'];
        $twitter->config['user_secret'] = $oauth_creds['oauth_token_secret'];
        
        $url = $twitter->url('oauth/authorize', '') . "?oauth_token={$oauth_creds['oauth_token']}";
        echo "Copy and paste this URL into your web browser and follower the prompts to get a pin code.\n" . $url . "\n";
    } else {
        echo "There was an error communicating with Twitter. {$twitter->response['response']}" . PHP_EOL;
        die();
    }
}

function access_token($twitter, $pin, $args) {
    $code = $twitter->request('POST', $twitter->url('oauth/access_token', ''), array( 'oauth_verifier' => trim($pin) ));

    if( $code == 200 )
    {
        $oauth_creds = $twitter->extract_params($twitter->response['response']);
        $db = new Db;
        $data['name'] = $oauth_creds['screen_name'];
        $data['token'] = $oauth_creds['oauth_token'];
        $data['secret'] = $oauth_creds['oauth_token_secret'];
        $data['ID_source'] = $args['source'];
        $db->insert( $data, "accounts" );
        echo "User: " . $oauth_creds['screen_name'] . " Token: " . $oauth_creds['oauth_token'] . " Secret: " . $oauth_creds['oauth_token_secret'] . "\n";
    } else {
        echo "There was an error communicating with Twitter. {$twitter->response['response']}" . PHP_EOL;
    }
}

function account( $args )
{
    require_once( "classes/twitter/tmhOAuth.php" );
    require_once( "classes/twitter/tmhUtilities.php" );
    require_once( "settings/app.php" );

    $twitter = new tmhOAuth( array(
        'consumer_key'    => $twitterKey,
        'consumer_secret' => $twitterSecret,
    ) );

    request_token( $twitter );
    $pin = tmhUtilities::read_input( 'What was the Pin Code?: ' );
    access_token( $twitter, $pin, $args );    
}

$args = Cli::parseArgs($_SERVER['argv']);
switch( $args[0] )
{
    case "pages":
        if( !$args['source'] )
            die( "Uso: dbcreate.php pages --source=# [--template]\n" );
        else
            pages( $args );
        break;
    case "account":
        if( !$args['source'] )
            die( "Uso: dbcreate.php account --source=#\n" );
        else 
            account( $args );
    default:
        die( "Uso: dbcreate COMMAND [parameters]\nCOMMANDS:\n*pages\t\t\tmanage pages\n*acount\t\t\tcreate account\n" );
}
?>
