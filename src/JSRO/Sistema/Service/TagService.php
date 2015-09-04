<?php
namespace JSRO\Sistema\Service;

use Doctrine\ORM\EntityManager;
use JSRO\Sistema\Entity\Tag as TagEntity;

class TagService
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function insert(array $data)
    {
        $tagEntity = new TagEntity();
        $tagEntity->setNome($data['nome']);

        $this->em->persist($tagEntity);
        $this->em->flush();

        return $tagEntity;
    }

    public function update($id, array $array)
    {
        $tag = $this->em->getReference('JSRO\Sistema\Entity\Tag', $id);

        $tag->setNome($array['nome']);

        $this->em->persist($tag);
        $this->em->flush();

        return $tag;
    }

    public function fetchAll()
    {
        $repo = $this->em->getRepository('JSRO\Sistema\Entity\Tag');
        return $repo->findAll();
    }

    public function find($id)
    {
        $repo = $this->em->getReference('JSRO\Sistema\Entity\Tag', $id);
        return $repo;
    }

    public function delete($id)
    {
        $tag = $this->em->getReference('JSRO\Sistema\Entity\Tag', $id);
        $this->em->remove($tag);
        $this->em->flush();
        return true;
    }

} 