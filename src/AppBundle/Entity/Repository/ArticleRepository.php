<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Article;
use AppBundle\Entity\User;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Query\Expr\Join;

/**
 * ArticleRepository.
 */
class ArticleRepository extends AbstractListRepository
{
    /**
    * Получить список 
     *
     * @param array $options список 
     *
     * @return QueryBuilder
     */
    public function getItems($options = ['status' => 1])
    {
        $em = $this->getEntityManager();
        $select = $em->createQueryBuilder()
            ->select('c')
            ->from(Article::class, 'c')
            ->orderBy('c.cdate', 'DESC');

        if (isset($options['status'])) {
            $select =$select
                ->andWhere('c.status = :status')
                ->setParameter('status', $options['status']);

            if ($options['status'] == 1) {
                $select
                    ->join('c.user', 'u')
                    ->andWhere('u.status = 1')
                    ->andWhere('u.designer = 1');
            }
        }

        if (isset($options['designers']) && $options['designers']) {
            $select =$select
                ->andWhere('c.user IN (:designerIds)')
                ->setParameter('designerIds', $options['designers']);
        }

        return $select;
    }
}
