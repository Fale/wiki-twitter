<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<?php
$path = "/home/dyrki/dev/classes/dyrki/itwp/";
$a = Array();
if( $handle = opendir( $path ) )
{
    while( false != ( $entry = readdir ( $handle ) ) )
    {
        if( $entry != ".." && $entry != "." )
        {
            $file = file( $path . $entry );
            $name = explode( " ", $file['5'] );
            $in = 0;
            $n = Array( '1' => Array(), '2' => Array(), '3' => Array(), '4' => Array());
            $par = 0;
            $id = 0;
            foreach( $file as $line )
            {
                $line = trim( $line );
                if( $line == 'public function tAll( $s )' )
                    $in = 1;
                if( $line == '{' && $in == 1 )
                    $par = $par + 1;
                if( $in )
                {
                    if( $id )
                    {
                        preg_match( '/.*\$this-\>([^\(]*).*/', $line, $m );
                        $n[$id][] = $m[1];
                        $id = 0;
                    }
                    if( preg_match( '/if\( \$this-\>devel\[\'[0-9]\'\] \)/', $line ) )
                        $id = $line['18'];
                }
                if( $line == '}' && $in == 1 )
                {
                    $par = $par - 1;
                    if( !$par )
                        $in = 0;
                }
            }
            $a[$name[1]] = $n;
        }
    }
}
?>

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>DyrKi status</title>
        <meta name="generator" content="Kate" />
        <style type="text/css">
            /*<![CDATA[*/
                th {background-color: #DDDDFF}
                td {background-color: #EEEEFF;}
                td:first-child{text-align: center;}
                table {width:100%}
                th.c1 {width:20%}
            /*]]>*/
        </style>
    </head>

    <body>
        <table summary="itwp">
            <tr>
                <th rowspan="2" class="c1">Class</th>
                <th colspan="4">functions</th>
            </tr>
            <tr>
                <th class="c1">Stable</th>
                <th class="c1">RC</th>
                <th class="c1">Alpha</th>
                <th class="c1">ToDo</th>
            </tr>
            <?php foreach( $a as $class => $levls ) { ?>
            <tr>
                <td><?php echo $class; ?></td>
                <?php foreach( $levls as $funcs ) { ?>
                <td>
                    <ul>
                        <?php foreach( $funcs as $func ) { ?>
                            <li><?php echo $func; ?></li>
                        <?php } ?>
                    </ul>
                </td>
                <?php }  ?>
            </tr>
            <?php } ?>
        </table>
    </body>
</html>
