<?php

namespace SnowTricksBundle\Repository;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TricksRepository extends \Doctrine\ORM\EntityRepository
{
    public function getAllTricks($page, $maxPerPage)
    {
        $db = $this->createQueryBuilder('t')
            ->where('CURRENT_DATE() >= t.createdAt');
        $query = $db->getQuery();

        $firstResult = ($page - 1) * $maxPerPage;
        $query->setFirstResult($firstResult)->setMaxResults($maxPerPage);
        $paginator = new Paginator($query);
        $result = ceil($paginator->count() / ((float)$maxPerPage));

        if(($paginator->count() <= $firstResult) && $page != 1)
        {
            throw new NotFoundHttpException('Erreur, vous avez indiqué un numéro de page incorrect, il y a actuellement '.$result.' pages!
            Veuillez indiqué un numéro de page entre 1 à '.$result);
        }

        return $paginator;
    }
}