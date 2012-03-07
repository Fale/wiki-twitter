<?php

require_once( "classes/wiki/botclasses.php" );
require_once( "classes/db.php" );
require_once( "classes/cli.php" );

class Tools
{
    private $db;

    public function __construct()
    {
        $this->db = new Db;
    }

    public function source( $args )
    {
        $r['prefix'] = $args['prefix'];
        $r['url'] = $args['url'];
        $r['apiurl'] = $args['apiurl'];
        $q = $this->db->insert( $r, "sources" );
        $pages = "CREATE TABLE IF NOT EXISTS `" . $args['prefix'] . "_pages` (
            `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `url` varchar(255) NOT NULL,
            `short` varchar(10) NOT NULL,
            PRIMARY KEY (`ID`)
        ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
        $relations = "CREATE TABLE IF NOT EXISTS `" . $args['prefix'] . "_relations` (
            `ID` int(8) unsigned NOT NULL AUTO_INCREMENT,
            `page` int(8) unsigned NOT NULL,
            `template` int(3) unsigned NOT NULL,
            PRIMARY KEY (`ID`),
            KEY `page` (`page`)
        ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
        $p = $this->db->query( $pages );
        $r = $this->db->query( $relations );
    }

    public function template( $args )
    {
        $r['template'] = $args['template'];
        $r['function'] = $args['function'];
        $r['ID_source'] = $args['source'];
        $q = $this->db->insert( $r, "templates" );
    }

    public function pages( $args )
    {
        $src = $this->db->query( "SELECT * FROM `sources` WHERE `ID_source` = '" . $args['source'] . "';" );
        $prefix = $src['0']['prefix'];
        $apiurl = $src['0']['apiurl'];
        $wiki = new extended( $apiurl );
        
        if( $args['template'] )
            $where = " AND `template` = '" . $args['template'] . "';";
        else
            $where = ";";

        $tpls = $this->db->query( "SELECT * FROM templates WHERE `ID_source` = '" . $args['source'] . "'" . $where );
        foreach( $tpls as $tpl )
        {
            $pages = $wiki->whatusethetemplate( $tpl['template'] );
            foreach( $pages as $page )
            {
                $p['url'] = mysql_escape_string( $page );
                $r['page'] = $this->db->smartinsert( $p, $prefix . "_pages", "url" );
                echo $p['url'] . " (Tpl:" . $tpl['template'] . ") (ID:" . $r['page'] . ")\n";
                if( $r['page'] )
                {
                    $r['template'] = $tpl['ID_template'];
                    $this->db->insert( $r, $prefix . "_relations" );
                }
                else
                {
                    $rels = $this->db->query( " SELECT * FROM " . $prefix . "_relations WHERE `page` = ( SELECT ID FROM " . $prefix . "_pages WHERE `url` = '" . $p['url'] . "');" );
                    if( $rels )
                    {
                        foreach( $rels as $rel )
                        {
                            if( $rel['template'] == '0' )
                            {
                                $r['ID'] = $rel['ID'];
                                $r['template'] = $tpl['ID_template'];
                                $r['page'] = mysql_escape_string( $rel['page'] );
                                $this->db->update( $r, $prefix . "_relations", "ID" );
                                echo "f";
                            }
                            elseif( $rel['template'] != $tpl['ID_template'] )
                            {
                                $re = $this->db->query( "SELECT ID FROM " . $prefix . "_pages WHERE `url` = '" . $p['url'] . "';" );
                                $r['template'] = $tpl['ID_template'];
                                $r['page'] = $re['0']['ID'];
                                $this->db->insert( $r, $prefix . "_relations" );
                                echo "a";
                            }
                        }
                    }
                    else
                    {
                        $re = $this->db->query( "SELECT ID FROM " . $prefix . "_pages WHERE `url` = '" . $p['url'] . "';" );
                        $r['template'] = $tpl['ID_template'];
                        $r['page'] = $re['0']['ID'];
                        $this->db->insert( $r, $prefix . "_relations" );
                        echo "a";
                    }

                }
            }
        }
    }

    public function request_token($twitter)
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

    public function access_token($twitter, $pin, $args)
    {
        $code = $twitter->request('POST', $twitter->url('oauth/access_token', ''), array( 'oauth_verifier' => trim($pin) ));

        if( $code == 200 )
        {
            $oauth_creds = $twitter->extract_params($twitter->response['response']);
            $data['name'] = $oauth_creds['screen_name'];
            $data['token'] = $oauth_creds['oauth_token'];
            $data['secret'] = $oauth_creds['oauth_token_secret'];
            $data['ID_source'] = $args['source'];
            $data['auto-follow'] = $args['auto-follow'];
            $this->db->insert( $data, "accounts" );
            echo "User: " . $oauth_creds['screen_name'] . " Token: " . $oauth_creds['oauth_token'] . " Secret: " . $oauth_creds['oauth_token_secret'] . "\n";
        } else {
            echo "There was an error communicating with Twitter. {$twitter->response['response']}" . PHP_EOL;
        }
    }

    public function account( $args )
    {
        require_once( "classes/twitter/tmhOAuth.php" );
        require_once( "classes/twitter/tmhUtilities.php" );
        require_once( "settings/app.php" );

        $twitter = new tmhOAuth( array(
            'consumer_key'    => $twitterKey,
            'consumer_secret' => $twitterSecret,
        ) );

        $this->request_token( $twitter );
        $pin = tmhUtilities::read_input( 'What was the Pin Code?: ' );
        $this->access_token( $twitter, $pin, $args );    
    }

    public function follow( $args )
    {
        require_once( "classes/twitter/tmhOAuth.php" );
        require_once( "classes/twitter/tmhUtilities.php" );
        require_once( "settings/app.php" );

        if( $args['1'] == "ALL" )
            $users = $this->db->query( "SELECT `name`, `token`, `secret` FROM `accounts` WHERE `auto-follow` = 1;" );
        else
            $users = $this->db->query( "SELECT `name`, `token`, `secret` FROM `accounts` WHERE `name`='" . $args['1'] . "';" );
        if( $args['2'] == "ALL" )
            $names = $this->db->query( "SELECT `name` FROM `accounts`;" );
        else
            $names = Array( 0 => Array( 'name' => $args['2'] ) );
        foreach( $users as $user )
        {
            $twitter = new tmhOAuth( Array( 
                'consumer_key' => $twitterKey, 
                'consumer_secret' => $twitterSecret, 
                'user_token' => $user['token'],
                'user_secret' => $user['secret']
            ) );
            foreach( $names as $name )
            {
                $t = $twitter->request( 'POST', $twitter->url( '1/friendships/create' ), Array( 'screen_name' =>  $name['name'], 'follow' => TRUE ) );
                echo $user['name'] . " will follow " . $name['name'] . " ";
                if( $code == 200 )
                    echo "Done\n";
                elseif( $code == 403 )
                    echo "Already Done\n";
                else
                    echo "Something went wrong\n";
                }
        }
    }
}
?>
