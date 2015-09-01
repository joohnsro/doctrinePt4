<?php
namespace JSRO\Sistema\Service;

use Doctrine\ORM\EntityManager;
use JSRO\Sistema\Entity\Cliente as ClienteEntity;

class ClienteService
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function insert(array $data)
    {
        $clienteEntity = new ClienteEntity();
        $clienteEntity->setNome($data['nome']);
        $clienteEntity->setEmail($data['email']);

        $this->em->persist($clienteEntity);
        $this->em->flush();

        return $clienteEntity;
    }

    public function update($id, array $array)
    {
        $cliente = $this->em->getReference('JSRO\Sistema\Entity\Cliente', $id);

        $cliente->setNome($array['nome']);
        $cliente->setEmail($array['email']);

        $this->em->persist($cliente);
        $this->em->flush();

        return $cliente;
    }

    public function fetchAll()
    {
        $repo = $this->em->getRepository('JSRO\Sistema\Entity\Cliente');
        return $repo->findAll();
    }

    public function find($id)
    {
        $repo = $this->em->getRepository('JSRO\Sistema\Entity\Cliente');
        return $repo->find($id);
    }

    public function delete($id)
    {
        $cliente = $this->em->getReference('JSRO\Sistema\Entity\Cliente', $id);
        $this->em->remove($cliente);
        return true;
    }

    public function getSearchResult(array $search)
    {
        if (!isset($search['limit']) || $search['limit'] == '') {
            $search['limit'] = 10;
        }

        if (!isset($search['page']) || $search['page'] == '' || $search['page'] == 0 || !is_numeric($search['page'])) {
            $search['page'] = 1;
        }

        $repo = $this->em->getRepository('JSRO\Sistema\Entity\Cliente');
        $data = [
            'data' => $repo->getSearchResultDql($search),
            'info' => $repo->getTotalNumSearch($search)
            ];

        return $data;
    }

} 