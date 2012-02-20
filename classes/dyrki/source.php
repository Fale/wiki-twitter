<?php
class Source
{
    private structure = Array(
        1 => Array(
            "short" => "itwp"
        ),
        2 => Array(
            "short" => "enwp"
    );

    private data;

    public function __construct( $source )
    {
        if( $source >= 1 && $source <= 2 )
            $this->data = $this->structure[$source];
    }

    public function short()
    {
        return $this->data['short'];
    }
}
