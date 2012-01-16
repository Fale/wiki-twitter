<?php

class Bitly {

    private $login;
    private $appkey;

    function __construct($login, $appkey) {
        $this->login = $login;
        $this->appkey = $appkey;
    }

    function shorten($url) {
        return $this->curl_get_result("http://api.bit.ly/v3/shorten?login={$this->login}&apiKey={$this->appkey}&uri=".urlencode($url)."&format=txt");
    }

    function expand($url) {
        return $this->curl_get_result("http://api.bit.ly/v3/expand?login={$this->login}&apiKey={$this->appkey}&shortUrl=".urlencode($url)."&format=txt");
    }

    private function curl_get_result($url) {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

}

?>
