<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>DyrKi status</title>
        <meta name="generator" content="Kate" />
        <style type="text/css">
            /*<![CDATA[*/
                th {background-color: #DDDDFF}
                td {background-color: #EEEEFF}
                tr#d1000 {color: red; font-weight: bold}
                table {width:100%}
                th.c1 {width:20%}
            /*]]>*/
        </style>
    </head>

    <body>
        <table summary="itwp">
            <tr>
                <th rowspan="2" class="c1">Class</th>
                <th colspan="4">Functions</th>
            </tr>
            <tr>
                <th class="c1">Stable</th>
                <th class="c1">RC</th>
                <th class="c1">Beta</th>
                <th class="c1">Alpha</th>
            </tr>
            <?php
                $vals = Array( 'd0000', 'd0001', 'd0010', 'd0011', 
                               'd0100', 'd0101', 'd0110', 'd0111', 
                               'd1000', 'd1001', 'd1010', 'd1011',
                               'd1100', 'd1101', 'd1110', 'd1111' );
                foreach( $vals as $val )
                {
                    echo"           <tr id=\"" . $val . "\">";
                    echo"               <td>" . $val . "</td>";
                    echo"               <td>" . ($val['1'] ? "S&igrave;":"No") . "</td>";
                    echo"               <td>" . ($val['2'] ? "S&igrave;":"No") . "</td>";
                    echo"               <td>" . ($val['3'] ? "S&igrave;":"No") . "</td>";
                    echo"               <td>" . ($val['4'] ? "S&igrave;":"No") . "</td>";
                    echo"           </tr>";
                }               
            ?>
        </table>
    </body>
</html>

