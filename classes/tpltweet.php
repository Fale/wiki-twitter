<?php
class TplTweet
{
    private $id;
    private $short;
    private $url;
    private $tpl;

    public function __construct( $array )
    {
        $this->id = $array['ID'];
        $this->short = $array['short'];
        $this->url = $array['url'];
        $this->tpl = $array['template'];
    }
}
?>
