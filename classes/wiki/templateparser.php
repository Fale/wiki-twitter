<?php
require_once( "botclasses.php" );

class TemplateParser
{
    private $w;
    protected $array;
    private $pages;

    public function __construct( $url )
    {
        $this->w = new extended;
        if( $url )
            $this->w->url = $url;
        else
            $this->w->url = 'http://it.wikipedia.org/w/api.php';
    }

    public function pages( $template )
    {
        $this->pages = $this->w->whatusethetemplate( $template );
    }

    public function getUrl( $template, $url )
    {
        $page = str_replace( "http://it.wikipedia.org/wiki/", '', $url );
        return $this->getPage( $template, $page );
    }

    public function getPage( $template, $page, $clean = 1 )
    {
        if( !$page )
            die( 'No page selected' );
        $this->array = $this->parse( $this->w->gettemplate( $page, $template ), $clean );
        return $this->array;
    }

    public function clean( $data )
    {
        preg_match_all( "/\[\[([^\|\]]+)[\|]?([^\|\]]*)\]\]/", $data, $matches, PREG_SET_ORDER );
        if( isset( $matches ) )
            foreach( $matches as $match )
            {
                if( $match[2] )
                    $ok = $match[2];
                else
                    $ok = $match[1];
                $data = str_replace( $match[0], $ok, $data );
            }
        preg_match_all( "/\<\!--[^-]*--\>/", $data, $ms, PREG_SET_ORDER );
        if( isset( $ms ) )
            foreach( $ms as $m )
                $data = str_replace( $m[0], "", $data );
        preg_match_all( "/\<ref>[^\<]*\<\/ref\>/", $data, $ms, PREG_SET_ORDER );
        if( isset( $ms ) )
            foreach( $ms as $m )
                $data = str_replace( $m[0], "", $data );
        preg_match_all( "/\<br\[^\>]*>/", $data, $ms, PREG_SET_ORDER );
        if( isset( $ms ) )
            foreach( $ms as $m )
                $data = str_replace( $m[0], "", $data );
        return $data;
    }

    public function parse( $data, $clean = 1 )
    {
        preg_match_all( "/\|([^=]*)=(.*)/i", $data, $matches, PREG_SET_ORDER );
        $this->array = Array();
        foreach( $matches as $match )
        {
            if( $clean )
                $this->array[ucfirst( strtolower( trim( $match[1] ) ) )] = trim( $this->clean( $match[2] ) );
            else
                $this->array[ucfirst( strtolower( trim( $match[1] ) ) )] = trim( $match[2] );
        }
        return $this->array;
    }
}

?>
