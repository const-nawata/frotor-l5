<?php

$url	= 'http://www.stackoverflow.com/questions/4378479/regular-expression-to-get-the-main-domain-of-a-url/?r=ffTiuiuyfgv4wf8sgsg445sfs44';

// preg_match_all("/((?:[a-z][a-z\\.\\d\\-]+)\\.(?:[a-z][a-z\\-]+))(?![\\w\\.])/", $url, $result, PREG_PATTERN_ORDER);
// $domain	= $result[0][0];



// $host = parse_url($url, PHP_URL_SCHEME,PHP_URL_HOST);


$url_parts	= [
	'protocol'	=> parse_url( $url, PHP_URL_SCHEME ),
	'host'		=> parse_url( $url, PHP_URL_HOST ),
	'path'		=> parse_url( $url, PHP_URL_PATH ),
	'query'		=> parse_url( $url, PHP_URL_QUERY )
];

// $host = array_reverse(explode('.', $host));
// $host = $host[1].'.'.$host[0];







echo '<pre style="text-align:left;font-size:10px;">'.print_r($url_parts , true ).'</pre>';

// echo $domain;