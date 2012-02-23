<?php

### SETTINGS ###
require_once( "../../settings/db.php" );

### CLASSES ###
require_once( "core.php" );
require_once( "../db.php" );

class Core
{
    private $db;
    private $url;
    private $tpls;
    private $pages;
    private $prefix;

    public function __construct( $prefix, $url )
    {
        $this->prefix = $prefix
        $this->url = $url;
        $this->db = new Db;
        $this->tpls = $this->db->query( "SELECT * FROM " . $this->prefix . "_templates;" );
        $this->pages = $this->db->query( "SELECT ID, url, short FROM "  . $this->prefix . "_pages ORDER BY RAND() LIMIT 10;" );
    }

    public function parsePage()
    {
        foreach( $rows as $row )
        {
            if( $row['short'] )
                /// initializeClass;
        }
    }

    public function initializeClass()
    {
        $tpl = $db->query( "SELECT `template` FROM itwp_relations WHERE `page` = " . $row['ID'] . ";" );
        $tpid = $tpl['0']['template'];
        $this->tpl = NULL;
        switch( $tpid )
        {
            case 2:
                $this->tpl = new DivisioneAmministrativa( $url );
            break;
            case 3:
                $this->tpl = new Bio( $url );
            break;
            case 4:
                $this->tpl = new Film( $url );
            break;
        }
    }

    public function createTweets()
    {
        if( $t )
            {
                $t->getUrl( $tp[$tpid-1]['template'] , $row['url'] );
                $o = $t->tAll( $row['short'] );
                if( $o )
                    $out = array_merge( $out, $o );
            }
        }
        $ok = Array();
        foreach( $out as $tw )
        {
            if( strlen( $tw ) <= 140 )
                array_push( $ok, $tw );
        }

        print_r( $ok );
        echo $out[array_rand( $ok )] . "\n";
    }
}
?>
