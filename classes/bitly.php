<?php

class Bitly
{
    public static function shorten( $url, $login, $appkey, $format = 'txt' )
    {
        $u = 'http://api.bit.ly/v3/shorten?login=' . $login . '&apiKey=' . $appkey . '&uri=' . urlencode( $url ) . '&format=' . $format;
        return curl_get_result( $u );
    }
}

?>
