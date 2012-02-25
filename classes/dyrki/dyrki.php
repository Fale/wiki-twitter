<?php

define( '__ROOT__', dirname( dirname( dirname( __FILE__ ) ) ) ); 
### SETTINGS ###
require_once( __ROOT__ . "/settings/db.php" );

### CLASSES ###
require_once( __ROOT__ . "/classes/db.php" );
require_once( __ROOT__ . "/classes/dyrki/itwp/bio.php" );
require_once( __ROOT__ . "/classes/dyrki/itwp/divisioneamministrativa.php" );
require_once( __ROOT__ . "/classes/dyrki/itwp/film.php" );

class Dyrki
{
    private $db;
    private $apiurl;
    private $id;
    private $url;
    private $tpls;
    private $prefix;
    private $tweets;
    private $debug;

    public function __construct( $id, $debug = 0 )
    {
        $this->db = new Db;
        $q = $this->db->query( "SELECT * FROM sources WHERE `ID_source` = ( SELECT `ID_source` FROM accounts WHERE `ID` = '" . $id . "');" );
        $this->id = $id;
        $this->prefix = $q['0']['prefix'];
        $this->apiurl = $q['0']['apiurl'];
        $this->url = $q['0']['url'];
        $this->debug = $debug;
        $this->tpls = $this->db->query( "SELECT * FROM templates;" );
        array_unshift( $this->tpls, "" );
    }
    
    public function createTweets()
    {
        $pages = $this->db->query( "SELECT ID, url, short FROM "  . $this->prefix . "_pages WHERE `ID` IN (SELECT * FROM (SELECT `page` FROM " . $this->prefix . "_relations WHERE `template` IN (SELECT `ID_template` FROM relations WHERE `ID_account` = '" . $this->id . "') ORDER BY RAND() LIMIT 10) alias);" );
        $out = Array();
        foreach( $pages as $row )
        {
            if( $row['short'] )
            {
                $tpl = $this->db->query( "SELECT `template` FROM " . $this->prefix . "_relations WHERE `page` = " . $row['ID'] . ";" );
                $function = $this->tpls[$tpl['0']['template']]['function'];
                $template = $this->tpls[$tpl['0']['template']]['template'];
                if( $function )
                {
                    $t = new $function( $this->apiurl );
                    $t->getUrl( $template, $row['url'] );
                    $o = $t->tAll( $row['short'] );
                    if( $o )
                        $out = array_merge( $out, $o );
                }
            }
        }
        $ok = Array();
        foreach( $out as $tw )
        {
            if( strlen( $tw ) <= 140 )
                array_push( $ok, $tw );
        }
        return $ok;
    }
}
?>
