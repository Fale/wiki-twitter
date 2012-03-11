<?php
require_once( "classes/bitly.php" );
require_once( "classes/db.php" );
require_once( "classes/cron.php" );

if( ( $pid = Cron::lock() ) !== FALSE )
{
    $db = new Db;
    $item = 0;
    $bitly = new Bitly( "o_247usnifoe", "R_bf87ec63f9a0a974df98cebebdcb7b8d");
    $sources = $db->query( "SELECT * FROM sources" );
    foreach( $sources as $source )
    {
        $p = $source['prefix'];
        echo $p . " ";
        $pages = $db->query( "SELECT * FROM " . $p . "_pages WHERE short = '' OR short = 'INVALID_LO' OR short = 'RATE_LIMIT' OR short = 'UNKNOWN_ER'" );
        echo "\033[00;32m[ OK ]\033[00m\n";
        $items = count( $pages );
        foreach( $pages as $page )
        {
            $item = $item + 1;
            echo "(" . $item . "/" . $items . ") " . $page['url'] . " (" . $page['ID'] . ") ";
            $r['ID'] = $page['ID'];
            $r['short'] = $bitly->shorten( $source['url'] . $page['url'] );
            echo "\033[00;32m[ OK ]\033[00m\n";
            if( $r['short'] == "INVALID_LOGIN" || $r['short'] == "RATE_LIMIT_EXCEEDED" || $r['short'] == "UNKNOWN_ERROR")
                die();
            $r['short'] = str_replace( "http://bit.ly/", '', $r['short'] );
            $db->update( $r, $p . "_pages", "ID" );
            usleep( 4 * 1000000 );
        }
    }
    Cron::unlock();
}
