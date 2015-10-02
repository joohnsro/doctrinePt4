<?php
namespace JSRO\Sistema\Service;

use Doctrine\ORM\EntityManager;
use JSRO\Sistema\Entity\Imagem as ImagemEntity;


class ImagemService
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function insert(array $data)
    {
        $imagemEntity = new ImagemEntity();
        $imagemEntity->setNome($this->ajusteDoNome($data['file']->getClientOriginalName()));
        $imagemEntity->setTitulo($data['titulo']);
        $imagemEntity->setDescricao($data['descricao']);
        $imagemEntity->setFile($data['file']);

        $this->em->persist($imagemEntity);
        $this->em->flush();

        $imagemEntity->setFile(null);

        return $imagemEntity;
    }

    public function update($id, array $array)
    {
        $imagem = $this->em->getReference('JSRO\Sistema\Entity\Imagem', $id);

        if (isset($array['nome'])) $imagem->setNome($this->ajusteDoNome($array['nome']));
        if (isset($array['titulo'])) $imagem->setTitulo($array['titulo']);
        if (isset($array['descricao'])) $imagem->setDescricao($array['descricao']);

        $this->em->persist($imagem);
        $this->em->flush();

        return $imagem;
    }

    public function fetchAll()
    {
        $repo = $this->em->getRepository('JSRO\Sistema\Entity\Imagem');
        return $repo->findAll();
    }

    public function find($id)
    {
        $repo = $this->em->getReference('JSRO\Sistema\Entity\Imagem', $id);
        return $repo;
    }

    public function delete($id)
    {
        $imagem = $this->em->getReference('JSRO\Sistema\Entity\Imagem', $id);
        $this->em->remove($imagem);
        $this->em->flush();
        return true;
    }

    public function ajusteDoNome($nome)
    {
        return str_replace(" ", "-", strtolower($nome));
    }

} 