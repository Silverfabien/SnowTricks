<?php

namespace SnowTricksBundle\Repository;

use Doctrine\ORM\Tools\Pagination\Paginator;

class TricksRepository extends \Doctrine\ORM\EntityRepository
{
    public function getAllPosts($currentPage = 1, $maxPerPage = 8)
    {
        $query = $this->createQueryBuilder('t')
            ->orderBy('t.createdAt', 'ASC')
            ->getQuery();

        $paginator = $this->paginate($query, $currentPage, $maxPerPage);

        return $paginator;
    }

    public function paginate($dql, $currentPage = 1, $maxPerPage = 8)
    {
        $paginator = new Paginator($dql);

        $paginator->getQuery()
            ->setFirstResult($maxPerPage * ($currentPage - 1))
            ->setMaxResults($maxPerPage);

        return $paginator;
    }
}