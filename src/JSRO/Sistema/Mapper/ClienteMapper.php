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

        return true;
    }

    public function update(Cliente $cliente)
    {
        $this->em->persist($cliente);
        $this->em->flush();

        return true;
    }

    public function delete(Cliente $cliente)
    {
        $this->em->remove($cliente);
        $this->em->flush();

        return true;
    }
}