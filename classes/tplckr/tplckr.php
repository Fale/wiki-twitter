<?php

define( '__ROOT__', dirname( dirname( dirname( __FILE__ ) ) ) ); 
define( '__HOME__', dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) ); 
### SETTINGS ###
require_once( __ROOT__ . "/settings/db.php" );

### CLASSES ###
require_once( __ROOT__ . "/classes/db.php" );
require_once( __ROOT__ . "/classes/tplckr/itwp/album.php" );
require_once( __ROOT__ . "/classes/tplckr/itwp/film.php" );

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
    private $file;

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
        $this->file = fopen( __HOME__ . "/public_html/" . $template . ".html", 'w' );
    }
    
    public function checkTemplate( $html = 1, $v = 1, $devel = "d1000" )
    {
        $function = $this->tpl['function'];
        $template = $this->tpl['template'];
        $t = new $function( $this->apiurl, $devel );
        $pages = $this->db->query( "SELECT * FROM " . $this->prefix . "_pages WHERE ID IN (SELECT `page` FROM " . $this->prefix . "_relations WHERE `template` = '" . $this->tpl['ID_template'] . "');" );
        if( $html )
            fwrite( $this->file, $this->HtmlHeader( $t->pHead() ) );
        else
        {
            $out = Array();
            array_unshift( $out, $t->pHead() );
        }
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
            if( $html )
                fwrite( $this->file, $this->HtmlContent( $pg ) );
            else
                array_push( $out, $pg );
            if( $v )
                echo "\033[00;32m[ OK ]\033[00m\n";
        }
        if( $html )
        {
            fwrite( $this->file, $this->HtmlFooter() );
            fclose( $this->file );
        }
        else
            return $out;
    }

    private function HtmlHeader( $array )
    {
        $out = "<table style=\"width:100%\">";
        $out.= "<tr>";
        foreach( $array as $cell )
        {
            $out.= "<th>";
            $out.= $cell;
            $out.= "</th>";
        }
        $out.= "</tr>";
        return $out;
    }

    private function HtmlContent( $array )
    {
        $out.= "<tr>";
        foreach( $array as $id => $cell )
        {
            $out.= "<td>";
            $out.= ( $id ? $cell : "<a href='" . $this->url . $cell . "'>" . $cell . "</a>" );
            $out.= "</td>";
        }
        $out.= "</tr>";
        return $out;
    }

    private function HtmlFooter()
    {
        $out = "</table>";
        return $out;
    }
}
?>
