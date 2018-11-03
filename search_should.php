<?php
require_once('config.php');

$conteudo = file_get_contents('gh95/topicos05.txt');

$tops = explode("<top>", $conteudo);
array_shift($tops);
foreach ($tops as $key => $top) {
    $topico = array(
        'num'   => trim(pega_texto($top, '<num> ',   '</num>')),
        'title' => trim(pega_texto($top, '<title> ', '<title>')),
        'desc'  => trim(pega_texto($top, '<desc> ',  '<desc>')),
        'narr'  => trim(pega_texto($top, '<narr> ',  '<narr>'))
    );

    $params = [
        //Número de documentos
         "size"     => 100,
        //Indice / tipo
        'index'     => 'gh95',
        'type'      => '_doc',
        //Query
        'body'      => [
            'query' => [
                'bool' => [
                    'should' => [
                        ['match' => ['HEADLINE' => str_replace('/', '', $topico['title'])]],
                        ['match' => ['TEXT' => str_replace('/', '', $topico['title'])]]
                    ]
                ]
            ]
        ]
    ];

    $response = $client->search($params);
    foreach ($response['hits']['hits'] as $key => $resultado) {
        $x = $key+1;
        echo "{$topico['num']}\tQ0\t{$resultado['_id']}\t{$x}\t{$resultado['_score']}\telasticsearch\n";
    }
}

