<?php
namespace JSRO\Sistema\Service;

use Doctrine\ORM\EntityManager;
use JSRO\Sistema\Entity\Image as ImageEntity;
use Symfony\Component\HttpFoundation\File\File;

class ImageService
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function insert(array $data)
    {
        $imageEntity = new ImageEntity();
        $imageEntity->setNome($this->ajusteDoNome($data['file']->getClientOriginalName()));
        $imageEntity->setTitulo($data['titulo']);
        $imageEntity->setDescricao($data['descricao']);
        $imageEntity->setFile($data['file']);

        $this->em->persist($imageEntity);
        $this->em->flush();

        $imageEntity->setFile(null);

        return $imageEntity;
    }

    public function update($id, array $array)
    {
        $image = $this->em->getReference('JSRO\Sistema\Entity\Image', $id);

        if (isset($array['nome'])) $image->setNome($this->ajusteDoNome($array['nome']));
        if (isset($array['titulo'])) $image->setTitulo($array['titulo']);
        if (isset($array['descricao'])) $image->setDescricao($array['descricao']);

        $this->em->persist($image);
        $this->em->flush();

        return $image;
    }

    public function fetchAll()
    {
        $repo = $this->em->getRepository('JSRO\Sistema\Entity\Image');
        return $repo->findAll();
    }

    public function find($id)
    {
        $repo = $this->em->getReference('JSRO\Sistema\Entity\Image', $id);
        return $repo;
    }

    public function delete($id)
    {
        $image = $this->em->getReference('JSRO\Sistema\Entity\Image', $id);
        $this->em->remove($image);
        $this->em->flush();
        return true;
    }

    public function ajusteDoNome($nome)
    {
        return str_replace(" ", "-", strtolower($nome));
    }

} 