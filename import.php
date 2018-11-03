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


$arquivos = glob("gh95/*{$_SERVER['argv'][1]}.sgml");


foreach ($arquivos as $key => $arquivo) {
	echo "{$arquivo} | $key/".count($arquivos)."\n";
	$conteudo = file_get_contents($arquivo);
	$docs     = explode("<DOC>", $conteudo);
    array_shift($docs);
	foreach ($docs as $key => $doc) {
		$documento = array(
			'DOCNO' 		=> pega_texto($doc, '<DOCNO>', 	'</DOCNO>'),
			'DOCID' 		=> pega_texto($doc, '<DOCID>', 		'</DOCID>'),
			'DATE' 			=> pega_texto($doc, '<DATE>', 			'</DATE>'),
			'HEADLINE' 		=> pega_texto($doc, '<HEADLINE>', 		'</HEADLINE>'),
			'BYLINE' 		=> pega_texto($doc, '<BYLINE>', 		'</BYLINE>'),
			'EDITION' 		=> pega_texto($doc, '<EDITION>', 		'</EDITION>'),
			'PAGE' 			=> pega_texto($doc, '<PAGE>', 			'</PAGE>'),
			'ARTICLETYPE' 	=> pega_texto($doc, '<ARTICLETYPE>', 	'</ARTICLETYPE>'),
			'GRAPHIC' 		=> pega_texto($doc, '<GRAPHIC>', 		'</GRAPHIC>'),
			'RECORDNO' 		=> pega_texto($doc, '<RECORDNO>', 		'</RECORDNO>'),
			'TEXT' 			=> pega_texto($doc, '<TEXT>', 			'</TEXT>'),
		);

		$params = [
            'index' => 'gh95',
            'type'  => '_doc',
            'id'    => $documento['DOCID'],
            'body'  => $documento
        ];

        $ignore = array(
        	'GH951118-000041', 
        	'GH951118-000018', 
        	'GH951117-000071', 
        	'GH951117-000040', 
        	'GH951116-000080', 
        	'GH951116-000076', 
        	'GH951116-000163'
        );
        if (in_array($params['id'], $ignore)) {
        	continue;
        }

        if ($params['id'] != '') {
            echo "{$arquivo} | {$params['id']}\n";
            try {
            	$response = $client->index($params);
			} catch (Exception $e) {
			    echo 'Exceção capturada: ',  $e->getMessage(), "\n";
			}
            //print_r($params);
        }
	}
}
