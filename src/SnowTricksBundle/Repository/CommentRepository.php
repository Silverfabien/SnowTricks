<?php

namespace SnowTricksBundle\Repository;

use Doctrine\ORM\Tools\Pagination\Paginator;
use SnowTricksBundle\Entity\Tricks;

class CommentRepository extends \Doctrine\ORM\EntityRepository
{
    public function getAllComments(Tricks $trick, $currentPage = 1, $maxPerPage = 10)
    {
        $query = $this->createQueryBuilder('c')
            ->where('c.trick = :trick')
            ->setParameter('trick', $trick)
            ->orderBy('c.createdAt', 'ASC')
            ->getQuery();

        $paginator = $this->paginate($query, $currentPage, $maxPerPage);

        return $paginator;
    }

    public function paginate($dql, $currentPage = 1, $maxPerPage = 10)
    {
        $paginator = new Paginator($dql);

        $paginator->getQuery()
            ->setFirstResult($maxPerPage * ($currentPage - 1))
            ->setMaxResults($maxPerPage);

        return $paginator;
    }
}