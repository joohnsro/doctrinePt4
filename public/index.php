<?php

require_once __DIR__ . '/../bootstrap.php';

use JSRO\Sistema\Service\ProdutoService;
use JSRO\Sistema\Service\CategoriaService;
use JSRO\Sistema\Service\TagService;
use Symfony\Component\HttpFoundation\Request;

$app['produtoService'] = function () use ($em) {
    $produtoService = new ProdutoService($em);
    return $produtoService;
};

$app['categoriaService'] = function () use ($em) {
    $categoriaService = new CategoriaService($em);
    return $categoriaService;
};

$app['tagService'] = function () use ($em) {
    $tagService = new TagService($em);
    return $tagService;
};

$app->get("/api/produtos", function () use ($app) {
    $dados = $app['produtoService']->fetchAll();
    $data = [];

    foreach ($dados as $dado) {
        $tags = [];

        foreach ($dado->getTags() as $tag) {
            $tags[] = [
                'id' => $tag->getId(),
                'nome' => $tag->getNome()
            ];
        }

        $data[] = [
            'id' => $dado->getId(),
            'nome' => $dado->getNome(),
            'descricao' => $dado->getDescricao(),
            'valor' => $dado->getValor(),
            'categoria' => [
                'id' => $dado->getCategoria()->getId(),
                'nome' => $dado->getCategoria()->getNome()
            ],
            'tags' => $tags
        ];
    }

    return $app->json($data);
});

$app->get("/api/produtos/{id}", function ($id) use ($app) {
    $dados = $app['produtoService']->find($id);

    $tags = [];
    foreach ($dados->getTags() as $tag) {
        $tags[] = [
            'id' => $tag->getId(),
            'nome' => $tag->getNome()
        ];
    }

    $data = [
        'id' => $dados->getId(),
        'nome' => $dados->getNome(),
        'descricao' => $dados->getDescricao(),
        'valor' => $dados->getValor(),
        'categoria' => [
            'id' => $dados->getCategoria()->getId(),
            'nome' => $dados->getCategoria()->getNome()
        ],
        'tags' => $tags
    ];

    return $app->json($data);
});

$app->post("/api/produtos", function (Request $request) use ($app) {
    $dados['nome'] = $request->get('nome');
    $dados['descricao'] = $request->get('descricao');
    $dados['valor'] = $request->get('valor');
    $dados['categoria'] = $request->get('categoria');
    $dados['tags'] = $request->get('tags');

    $result = $app['produtoService']->insert($dados);

    $data['id'] = $result->getId();
    $data['nome'] = $result->getNome();
    $data['descricao'] = $result->getDescricao();
    $data['valor'] = $result->getValor();
    $data['categoria'] = $result->getCategoria()->getNome();

    foreach ($result->getTags() as $tag) {
        $data['tags'][] = [
            'id' => $tag->getId(),
            'nome' => $tag->getNome()
        ];
    }

    return $app->json($data);
});

$app->put("/api/produtos/{id}", function ($id, Request $request) use ($app) {
    $dados['nome'] = $request->get('nome');
    $dados['descricao'] = $request->get('descricao');
    $dados['valor'] = $request->get('valor');
    $dados['categoria'] = $request->get('categoria');
    $dados['tags'] = $request->get('tags');

    $result = $app['produtoService']->update($id, $dados);

    $data['id'] = $result->getId();
    $data['nome'] = $result->getNome();
    $data['descricao'] = $result->getDescricao();
    $data['valor'] = $result->getValor();
    $data['categoria'] = $result->getCategoria()->getNome();

    foreach ($result->getTags() as $tag) {
        $data['tags'][] = [
            'id' => $tag->getId(),
            'nome' => $tag->getNome()
        ];
    }

    return $app->json($data);
});

$app->delete("/api/produtos/{id}", function ($id) use ($app) {
    $result = $app['produtoService']->delete($id);
    return $app->json($result);
});

$app->get("/api/categorias", function () use ($app) {
    $dados = $app['categoriaService']->fetchAll();
    $data = [];

    foreach ($dados as $dado) {
        $data[] = [
            'id' => $dado->getId(),
            'nome' => $dado->getNome()
        ];
    }

    return $app->json($data);
});

$app->get("/api/categorias/{id}", function ($id) use ($app) {
    $dados = $app['categoriaService']->find($id);

    $data = [
        'id' => $dados->getId(),
        'nome' => $dados->getNome()
    ];

    return $app->json($data);
});

$app->post("/api/categorias", function (Request $request) use ($app) {
    $dados['nome'] = $request->get('nome');

    $result = $app['categoriaService']->insert($dados);

    $data['id'] = $result->getId();
    $data['nome'] = $result->getNome();

    return $app->json($data);
});

$app->put("/api/categorias/{id}", function ($id, Request $request) use ($app) {
    $dados['nome'] = $request->get('nome');

    $result = $app['categoriaService']->update($id, $dados);

    $data['id'] = $result->getId();
    $data['nome'] = $result->getNome();

    return $app->json($data);
});

$app->delete("/api/categorias/{id}", function ($id) use ($app) {
    $result = $app['categoriaService']->delete($id);
    return $app->json($result);
});

$app->get("/api/tags", function () use ($app) {
    $dados = $app['tagService']->fetchAll();
    $data = [];

    foreach ($dados as $dado) {
        $data[] = [
            'id' => $dado->getId(),
            'nome' => $dado->getNome()
        ];
    }

    return $app->json($data);
});

$app->get("/api/tags/{id}", function ($id) use ($app) {
    $dados = $app['tagService']->find($id);

    $data = [
        'id' => $dados->getId(),
        'nome' => $dados->getNome()
    ];

    return $app->json($data);
});

$app->post("/api/tags", function (Request $request) use ($app) {
    $dados['nome'] = $request->get('nome');

    $result = $app['tagService']->insert($dados);

    $data['id'] = $result->getId();
    $data['nome'] = $result->getNome();

    return $app->json($data);

});

$app->put("/api/tags/{id}", function ($id, Request $request) use ($app) {
    $dados['nome'] = $request->get('nome');

    $result = $app['tagService']->update($id, $dados);

    $data['id'] = $result->getId();
    $data['nome'] = $result->getNome();

    return $app->json($data);

});

$app->delete("/api/tags/{id}", function ($id) use ($app) {
    $result = $app['tagService']->delete($id);
    return $app->json($result);
});

$app->get("/", function () use ($app){
    return $app->json(['Utilize apenas as APIs REST.']);
})->bind("clientes");

$app->run();