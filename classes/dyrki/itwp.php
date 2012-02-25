<?php

require_once( "core.php" );
require_once( "itwp/bio.php" );
require_once( "itwp/film.php" );
require_once( "itwp/divisioneamministrativa.php" );

class itwp extends Core
{
    public function initializeClass()
    {
        $tpl = $db->query( "SELECT `template` FROM itwp_relations WHERE `page` = " . $row['ID'] );
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
}
?>
