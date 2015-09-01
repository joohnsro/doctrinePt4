<?php

require_once __DIR__ . '/../bootstrap.php';

use JSRO\Sistema\Service\ClienteService;
use Symfony\Component\HttpFoundation\Request;

$app['clienteService'] = function () use ($em) {
    $clienteService = new ClienteService($em);
    return $clienteService;
};

//GET     /api/clientes - Listar os clientes
//GET     /api/clientes/1 - Lista apenas um cliente passando o id por parâmetro
//POST    /api/clientes - Insere novo clienten
//PUT     /api/clientes/2
//DELETE  /api/clientes/2

$app->get("/api/clientes", function () use ($app) {
    $dados = $app['clienteService']->fetchAll();
//    return print_r($dados);
    return $app->json($dados);
});

$app->get("/api/clientes/{id}", function ($id) use ($app) {
    $dados = $app['clienteService']->find($id);
    return $app->json($dados);
});

$app->post("/api/clientes", function(Request $request) use ($app) {

    $dados['nome'] = $request->get('nome');
    $dados['email'] = $request->get('email');

    $result = $app['clienteService']->insert($dados);

    return $app->json($result);
});

$app->put("/api/clientes/{id}", function ($id, Request $request) use ($app) {

    $data['nome'] = $request->get('nome');
    $data['email'] = $request->get('email');

    $dados = $app['clienteService']->update($id, $data);
    return $app->json($dados);
});

$app->delete("/api/clientes/{id}", function ($id) use ($app) {
    $dados = $app['clienteService']->delete($id);
    return $app->json($dados);
});

$app->get("/", function (Request $request) use ($app){

    $search = [
        'search' => $request->get('search'),
        'limit'  => '',
        'page'   => $request->get('page'),
    ];

    $dados = $app['clienteService']->getSearchResult($search);

    return $app['twig']->render('clientes.twig', ['search' => $search, 'clientes'=>$dados['data'], 'info'=>$dados['info']]);
})->bind("clientes");

$app->run();