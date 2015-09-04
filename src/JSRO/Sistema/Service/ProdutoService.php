<?php
namespace JSRO\Sistema\Service;

use Doctrine\ORM\EntityManager;
use JSRO\Sistema\Entity\Produto as ProdutoEntity;

class ProdutoService
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function insert(array $data)
    {
        $produtoEntity = new ProdutoEntity();
        $produtoEntity->setNome($data['nome']);
        $produtoEntity->setDescricao($data['descricao']);
        $produtoEntity->setValor($data['valor']);

        if (isset($data['categoria'])) {
            $id = $data['categoria'];
            $categoriaEntity = $this->em->getReference("JSRO\Sistema\Entity\Categoria", $id);
            $produtoEntity->setCategoria($categoriaEntity);
        }

        if (isset($data['tags'])) {
            $tags = explode(",", $data['tags']);

            foreach ($tags as $tag) {
                $tagEntity = $this->em->getReference("JSRO\Sistema\Entity\Tag", $tag);
                $produtoEntity->addTag($tagEntity);
            }
        }

        $this->em->persist($produtoEntity);
        $this->em->flush();

        return $produtoEntity;
    }

    public function update($id, array $array)
    {
        $produto = $this->em->getReference('JSRO\Sistema\Entity\Produto', $id);

        $produto->setNome($array['nome']);
        $produto->setDescricao($array['descricao']);
        $produto->setValor($array['valor']);

        if (isset($array['categoria'])) {
            $id = $array['categoria'];
            $categoriaEntity = $this->em->getReference("JSRO\Sistema\Entity\Categoria", $id);
            $produto->setCategoria($categoriaEntity);
        }

        if (isset($array['tags'])) {
            $produto->clearTags();

            $tags = explode(",", $array['tags']);

            foreach ($tags as $tag) {
                $tagEntity = $this->em->getReference("JSRO\Sistema\Entity\Tag", $tag);
                $produto->addTag($tagEntity);
            }
        }

        $this->em->persist($produto);
        $this->em->flush();

        return $produto;
    }

    public function fetchAll()
    {
        $repo = $this->em->getRepository('JSRO\Sistema\Entity\Produto');
        return $repo->findAll();
    }

    public function find($id)
    {
        $repo = $this->em->getReference('JSRO\Sistema\Entity\Produto', $id);
        return $repo;
    }

    public function delete($id)
    {
        $produto = $this->em->getReference('JSRO\Sistema\Entity\Produto', $id);
        $this->em->remove($produto);
        $this->em->flush();
        return true;
    }

} 