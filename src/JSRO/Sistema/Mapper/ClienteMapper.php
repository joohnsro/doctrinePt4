<?php

namespace JSRO\Sistema\Mapper;

use JSRO\Sistema\Entity\Cliente;
use Doctrine\ORM\EntityManager;

class ClienteMapper
{

    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function insert(Cliente $cliente)
    {
        $this->em->persist($cliente);
        $this->em->flush();

        return [
            'id'      => $cliente->getId(),
            'nome'    => $cliente->getNome(),
            'email'   => $cliente->getEmail(),
        ];
    }

    public function update($id, $data)
    {
        $query = $this->em->createQueryBuilder()
            ->update('JSRO\Sistema\Entity\Cliente', 'c')
            ->set('c.nome', ':nome')
            ->set('c.email', ':email')
            ->where('c.id = :id')
            ->setParameter('id', $id)
            ->setParameter('nome', $data['nome'])
            ->setParameter('email', $data['email']);

         $query->getQuery()->execute();

        return $this->find($id);
    }

    public function find($id)
    {
        $query = $this->em->createQueryBuilder()
            ->select('c')
            ->from('JSRO\Sistema\Entity\Cliente', 'c')
            ->where('c.id = :id')
            ->setParameter('id', $id);

        return $query->getQuery()->getArrayResult();
    }

    public function delete($id)
    {
        $query = $this->em->createQueryBuilder()
            ->delete()
            ->from('JSRO\Sistema\Entity\Cliente', 'c')
            ->where('c.id = :id')
            ->setParameter('id', $id);

        return $query->getQuery()->execute();
    }

    public function fetchAll()
    {
        $query = $this->em->createQueryBuilder()
            ->select('c')
            ->from('JSRO\Sistema\Entity\Cliente', 'c');

        return $query->getQuery()->getArrayResult();
    }

}