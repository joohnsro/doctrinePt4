<?php

require_once __DIR__ . '/../bootstrap.php';

use JSRO\Sistema\Service\ProdutoService;
use JSRO\Sistema\Service\CategoriaService;
use JSRO\Sistema\Service\TagService;
use JSRO\Sistema\Service\ImagemService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

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

$app['imagemService'] = function () use ($em) {
    $imagemService = new ImagemService($em);
    return $imagemService;
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

$app->get("/api/imagens", function () use ($app) {
    $dados = $app['imagemService']->fetchAll();
    $data = [];

    foreach ($dados as $dado) {
        $data[] = [
            'id' => $dado->getId(),
            'nome' => $dado->getNome(),
            'titulo' => $dado->getTitulo(),
            'descricao' => $dado->getDescricao()
        ];
    }

    return $app->json($data);
});

$app->get("/api/imagens/{id}", function ($id) use ($app) {
    $dados = $app['imagemService']->find($id);

    $data = [
        'id' => $dados->getId(),
        'nome' => $dados->getNome(),
        'titulo' => $dados->getTitulo(),
        'descricao' => $dados->getDescricao(),
        'createdAt' => $dados->getCreatedAt()
    ];

    return $app->json($data);
});

$app->post("/api/imagens", function (Request $request) use ($app) {
    $dados['nome'] = $request->get('nome');
    $dados['titulo'] = $request->get('titulo');
    $dados['descricao'] = $request->get('descricao');
    $dados['mimeType'] = $request->get('mimeType');
    $dados['fileSize'] = $request->get('fileSize');

    $result = $app['imagemService']->insert($dados);

    $data['id'] = $result->getId();
    $data['nome'] = $result->getNome();
    $data['titulo'] = $result->getTitulo();
    $data['descricao'] = $result->getDescricao();
    $dados['createdAt'] = $result->getCreatedAt();

    return $app->json($data);
});

$app->match("/", function (Request $request) use ($app) {

    $categorias = $app['categoriaService']->fetchAll();
    $catChoices = [];
    foreach ($categorias as $cat) {
        $catChoices[$cat->getId()] = $cat->getNome();
    }

    $tags = $app['tagService']->fetchAll();
    $tagChoices = [];
    foreach ($tags as $tag) {
        $tagChoices[$tag->getId()] = $tag->getNome();
    }

    $form = $app['form.factory']
        ->createBuilder('form')
        ->add('nome', 'text', array('label' => 'Nome'))
        ->add('descricao', 'textarea', array('label' => 'Descrição'))
        ->add('valor', 'text', array('label' => 'Valor'))
        ->add('categoria', 'choice', array('label' => 'Categoria', 'choices' => $catChoices))
        ->add('tags', 'choice', array('label' => 'Tags', 'choices' => $tagChoices, 'multiple' => true))
        ->add('imagem', 'file', array(
            'label' => "Foto",
            'attr' => array('class' => 'form-control'),
            'constraints' => array(new Assert\Image([
                "maxSize" => "5M",
                "maxSizeMessage" => "A imagem é grande demais, ela pode pesar apenas 5Mb.",
                "mimeTypes" => ["image/jpeg", "image/png"],
                "mimeTypesMessage" => "Por favor, insira uma imagem apenas nos formatos JPG e PNG.",
            ]))
        ))
        ->getForm();

    $form->handleRequest($request);

    if ($form->isValid()) {

        $formData = $form->getData();
        $dados['nome'] = $formData['nome'];
        $dados['descricao'] = $formData['descricao'];
        $dados['valor'] = $formData['valor'];
        $dados['categoria'] = $formData['categoria'];
        $dados['tags'] = $formData['tags'];

        if (isset($formData['imagem'])) {
            $dados['imagem'] = $app['imagemService']->insert([
                'titulo' => '',
                'descricao' => '',
                'file' => $formData['imagem']
            ]);
        }

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

        foreach ($result->getImagens() as $imagem) {
            $data['imagem'][] = [
                'id' => $imagem->getId(),
                'nome' => $imagem->getNome()
            ];
        }

        $app['session']->getFlashBag()->add('success', [
            'nome' => $data['nome'],
            'imagem' => $data['imagem'][0]['nome'],
            'message' => 'Produto cadastrado com sucesso.'
        ]);

        return $app->redirect($app['url_generator']->generate('addProduto'));

    }

    return $app['twig']->render(
        'upload.html.twig',
        array(
            'form' => $form->createView()
        )
    );

})->bind("addProduto")->method("GET|POST");

$app->run();