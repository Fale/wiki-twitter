<?php

define( '__ROOT__', dirname( dirname( dirname( __FILE__ ) ) ) ); 
echo __ROOT__;
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
    private $url;
    private $tpls;
    private $prefix;
    private $tweets;
    private $debug;

    public function __construct( $id, $debug = 0 )
    {
        $this->db = new Db;
        $q = $this->db->query( "SELECT * FROM accounts WHERE `ID` = '" . $id . "';" );
        $this->prefix = $q['0']['prefix'];
        $this->url = $q['0']['url'];
        $this->debug = $debug;
    }
    
    public function createTweets()
    {
        $this->tpls = $this->db->query( "SELECT * FROM " . $this->prefix . "_templates WHERE `ID` IN ( SELECT `ID_template` FROM relations WHERE `ID_account` = '" . $q['ID'] . "');" );
        $pages = $this->db->query( "SELECT ID, url, short FROM "  . $this->prefix . "_pages WHERE `ID` IN (SELECT * FROM (SELECT `page` FROM " . $this->prefix . "_relations ORDER BY RAND() LIMIT 10) alias);" );
        $out = Array();
        foreach( $pages as $row )
        {
            if( $row['short'] )
            {
                $tpl = $this->db->query( "SELECT `function`, `template` FROM " . $this->prefix . "_templates WHERE `ID` IN (SELECT `template` FROM " . $this->prefix . "_relations WHERE `page` = " . $row['ID'] . ");" );
                print_r( $row );
                $function = $tpl['0']['function'];
                if( $function )
                {
                    $t = new $function( $row['url'] );
                    $t->getUrl( $tpl['0']['template'] , $row['url'] );
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
        print_r( $ok );
    }
}
?>
