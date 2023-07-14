<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * AbstractListRepository
 * Репозиторий, содержащий дефолтные методы для работы со списковыми структурами.
 */
abstract class AbstractListRepository extends EntityRepository
{
    /**
     * Метод рассчета сортировки для вставки в конец списка. TODO: какого списка?
     *
     * @return int
     */
    public function getNextOrdering()
    {
        $select = $this->createQueryBuilder('t')
                ->select('MAX(t.ordering)')
                ->getQuery();
        $ordering = $select->getSingleScalarResult();

        return $ordering ? $ordering + 1 : 1;
    }
}
