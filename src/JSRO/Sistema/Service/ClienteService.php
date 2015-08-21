<?php
namespace JSRO\Sistema\Service;

use Doctrine\ORM\EntityManager;
use JSRO\Sistema\Entity\Cliente;
use JSRO\Sistema\Mapper\ClienteMapper;

class ClienteService
{
    private $cliente;
    private $clienteMapper;
    private $em;

    public function __construct(Cliente $cliente, ClienteMapper $clienteMapper, EntityManager $em)
    {
        $this->cliente = $cliente;
        $this->clienteMapper = $clienteMapper;
        $this->em = $em;
    }

    public function insert(array $data)
    {
        $this->cliente->setNome($data['nome']);
        $this->cliente->setEmail($data['email']);

        $this->clienteMapper->insert($this->cliente);

        return ['success' => true, 'data' => $this->cliente];
    }

    public function update($id, array $array)
    {
        $cliente = $this->em->find('JSRO\Sistema\Entity\Cliente', $id);

        if (!$cliente) {
            return ['error' => 'O cliente não existe.'];
        }

        $cliente->setNome($array['nome']);
        $cliente->setEmail($array['email']);

        $this->clienteMapper->update($cliente);

        return ['success' => true, 'data' => $cliente];
    }

    public function fetchAll()
    {
        return $this->em->getRepository('JSRO\Sistema\Entity\Cliente')->findAll();
    }

    public function find($id)
    {
        $cliente = $this->em->find('JSRO\Sistema\Entity\Cliente', $id);

        if (!$cliente) {
            return ['error' => 'O cliente não foi encontrado.'];
        }

        return ['success' => true, 'data' => $cliente];
    }

    public function delete($id)
    {
        $cliente = $this->em->find('JSRO\Sistema\Entity\Cliente', $id);

        if (!$cliente) {
            return ['error' => 'O cliente não existe.'];
        }

        $this->clienteMapper->delete($cliente);

        return ['success' => 'O cliente foi deletado com sucesso.'];
    }
} 