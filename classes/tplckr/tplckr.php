<?php

define( '__ROOT__', dirname( dirname( dirname( __FILE__ ) ) ) ); 
### SETTINGS ###
require_once( __ROOT__ . "/settings/db.php" );

### CLASSES ###
require_once( __ROOT__ . "/classes/db.php" );
require_once( __ROOT__ . "/classes/tplckr/itwp/album.php" );

class TplCkr
{
    private $db;
    private $id;
    private $tpl;
    private $url;
    private $prefix;
    private $apiurl;
    private $tweets;
    private $debug;

    public function __construct( $template, $debug = 0 )
    {
        $this->db = new Db;
        $this->id = $id;
        $this->debug = $debug;
        $this->tpl = $this->db->query( "SELECT * FROM templates WHERE `template`='" . $template . "';" );
        $this->tpl = $this->tpl['0'];
        $q = $this->db->query( "SELECT * FROM sources WHERE `ID_source` = '" . $this->tpl['ID_source'] . "';" );
        $this->prefix = $q['0']['prefix'];
        $this->apiurl = $q['0']['apiurl'];
        $this->url = $q['0']['url'];
    }
    
    public function checkTemplate( $toHtml = 1, $v = 1, $devel = "d1000" )
    {
        $function = $this->tpl['function'];
        $template = $this->tpl['template'];
        $t = new $function( $this->apiurl, $devel );
        $pages = $this->db->query( "SELECT * FROM " . $this->prefix . "_pages WHERE ID IN (SELECT `page` FROM " . $this->prefix . "_relations WHERE `template` = '" . $this->tpl['ID_template'] . "');" );
        $out = Array();
        array_unshift( $out, $t->pHead() );
        $tot = count( $pages );
        $p = 0;
        foreach( $pages as $page )
        {
            $p = $p + 1;
            if( $v )
                echo "(" . $p . "/" . $tot . ") " . $page['url'] . " ";
            $t->getPage( $template, $page['url'], 0 );
            $pg = $t->pAll();
            array_unshift( $pg, $page['url'] );
            array_push( $out, $pg );
            if( $v )
                echo "\033[00;32m[ OK ]\033[00m\n";
        }
        if( $html )
            return toHtml( $out );
        else
            return $out;
    }

    private function toHtml( $array )
    {
        $out = "<table>";
        foreach( $array as $id => $row )
        {
            $out.= "<tr>";
            foreach( $row as $cell )
            {
                $out.= ( !$id ? "<th>" : "<td>" );
                $out.= $cell;
                $out.= ( !$id ? "</th>" : "</td>" );
            }
            $out.= "</tr>";
        }
        $out.= "</table>";
    }
}
?>
