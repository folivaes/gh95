<?php
use Elasticsearch\ClientBuilder;
require 'vendor/autoload.php';

function pega_texto($texto, $ini, $fim){
	if (!substr_count($texto, $ini)) {
		return '';
	}
    $r = explode($ini, $texto, 2);
    $r = explode($fim, $r[1],  2);
    return $r[0];
}

$client = ClientBuilder::create()->build();

?>