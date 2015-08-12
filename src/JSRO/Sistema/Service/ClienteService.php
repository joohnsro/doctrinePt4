<?php
namespace JSRO\Sistema\Service;

use JSRO\Sistema\Entity\Cliente;
use JSRO\Sistema\Mapper\ClienteMapper;

class ClienteService
{

    private $cliente;
    private $clienteMapper;

    public function __construct(Cliente $cliente, ClienteMapper $clienteMapper)
    {
        $this->cliente = $cliente;
        $this->clienteMapper = $clienteMapper;
    }

    public function insert(array $data)
    {
        $clienteEntity = $this->cliente;
        $clienteEntity->setNome($data['nome']);
        $clienteEntity->setEmail($data['email']);

        $res = $this->clienteMapper->insert($clienteEntity);

        if (!$res) {
            return ['error' => 'Ocorreu um erro e o cliente não pôde ser inserido.'];
        }

        return ['success' => true, 'data' => $res];
    }

    public function update($id, array $array)
    {
        $res = $this->clienteMapper->update($id, $array);

        if (!$res) {
            return ['error' => 'O cliente não existe.'];
        }

        return ['success' => true, 'data' => $res];
    }

    public function fetchAll()
    {
        return $this->clienteMapper->fetchAll();
    }

    public function find($id)
    {
        $res = $this->clienteMapper->find($id);

        if (!$res) {
            return ['error' => 'O cliente não foi encontrado.'];
        }

        return ['success' => true, 'data' => $res];
    }

    public function delete($id)
    {
        $res = $this->clienteMapper->delete($id);

        if ($res != 1) {
            return ['error' => 'O cliente não foi encontrado.'];
        }

        return ['success' => 'O cliente foi deletado com sucesso.'];
    }

} 