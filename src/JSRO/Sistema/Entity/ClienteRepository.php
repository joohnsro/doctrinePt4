<?php

namespace JSRO\Sistema\Entity;

use Doctrine\ORM\EntityRepository;

class ClienteRepository extends EntityRepository
{

    public function getSearchResultQB(array $search)
    {
        return $this
            ->createQueryBuilder('c')
            ->where('c.nome LIKE :search')
            ->orWhere('c.email LIKE :search')
            ->setFirstResult(($search['page'] * $search['limit']) - $search['limit'])
            ->setMaxResults($search['limit'])
            ->setParameter('search', '%'.$search['search'].'%')
            ->getQuery()
            ->getResult();
    }

    public function getSearchResultDql(array $search)
    {
        $sql = "SELECT c FROM JSRO\Sistema\Entity\Cliente c WHERE c.nome LIKE :search OR c.email LIKE :search";

        return $this
            ->getEntityManager()
            ->createQuery($sql)
            ->setFirstResult(($search['page'] * $search['limit']) - $search['limit'])
            ->setMaxResults($search['limit'])
            ->setParameter('search', '%'.$search['search'].'%')
            ->getResult()
        ;
    }

    public function getTotalNumSearch(array $search)
    {
        $query = $this
            ->createQueryBuilder('c')
            ->select('count(c.id) as qtd_total')
            ->where('c.nome LIKE :search')
            ->orWhere('c.email LIKE :search')
            ->setParameter('search', '%'.$search['search'].'%')
            ->getQuery()
            ->getResult();

        $pages = ceil($query[0]['qtd_total']/$search['limit']);

        return [
            'qtd_total' => $query[0]['qtd_total'],
            'limit' => $search['limit'],
            'pages' => $pages
        ];

    }

} 