<?php

define( '__ROOT__', dirname( dirname( dirname( __FILE__ ) ) ) ); 
echo __ROOT__;
### SETTINGS ###
require_once( __ROOT__ . "/settings/db.php" );

### CLASSES ###
require_once( __ROOT__ . "/classes/db.php" );

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
        $q = $this->db->query( "SELECT * FROM accounts WHERE `ID`='" . $id . "';" );
        $this->prefix = $q['prefix'];
        $this->url = $q['url'];
        $this->debug = $debug;
    }
    
    public function createTweets()
    {
        $this->tpls = $this->db->query( "SELECT * FROM " . $this->prefix . "_templates WHERE `ID` = ( SELECT `ID_template` FROM relations WHERE `ID_account` = '" . $q['ID'] . "');" );
        $pages = $this->db->query( "SELECT ID, url, short FROM "  . $this->prefix . "_pages WHERE `ID` = ( SELECT `page` FROM " . $this->prefix . "_relations ORDER BY RAND() LIMIT 10);" );
        foreach( $pages as $row )
        {
            if( $row['short'] )
            {
                $tpl = $db->query( "SELECT `function` FROM " . $this->prefix . "_templates WHERE `ID` = (SELECT `template` FROM " . $this->prefix . "_relations WHERE `page` = " . $row['ID'] . ");" );
                print_r( $tpl );
            }
        }
    }
}
?>
