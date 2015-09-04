<?php
namespace JSRO\Sistema\Service;

use Doctrine\ORM\EntityManager;
use JSRO\Sistema\Entity\Categoria as CategoriaEntity;

class CategoriaService
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function insert(array $data)
    {
        $categoriaEntity = new CategoriaEntity();
        $categoriaEntity->setNome($data['nome']);

        $this->em->persist($categoriaEntity);
        $this->em->flush();

        return $categoriaEntity;
    }

    public function update($id, array $array)
    {
        $categoria = $this->em->getReference('JSRO\Sistema\Entity\Categoria', $id);

        $categoria->setNome($array['nome']);

        $this->em->persist($categoria);
        $this->em->flush();

        return $categoria;
    }

    public function fetchAll()
    {
        $repo = $this->em->getRepository('JSRO\Sistema\Entity\Categoria');
        return $repo->findAll();
    }

    public function find($id)
    {
        $repo = $this->em->getReference('JSRO\Sistema\Entity\Categoria', $id);
        return $repo;
    }

    public function delete($id)
    {
        $categoria = $this->em->getReference('JSRO\Sistema\Entity\Categoria', $id);
        $this->em->remove($categoria);
        $this->em->flush();
        return true;
    }

} 