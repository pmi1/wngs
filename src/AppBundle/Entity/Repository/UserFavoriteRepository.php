<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\UserFavorite;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Query\Expr\Join;

/**
 * UserFavoriteRepository.
 */
class UserFavoriteRepository extends AbstractListRepository
{
    /**
     * Получить количство
     *
     * @return int
     */
    public function getCount($userId)
    {
        $em = $this->getEntityManager();
        $count = $em->createQueryBuilder()
            ->select('count(1)')
            ->from(UserFavorite::class, 'c')
            ->join('c.item', 'i')
            ->where('i.status=1')
            ->join('i.user', 'r')
            ->andWhere('r.designer = 1 and r.activeCatalogue = 1')
            ->andWhere('c.user = :user')
            ->setParameter('user', $userId)
            ->getQuery()->getSingleScalarResult();
        
        return $count;
    }
}
