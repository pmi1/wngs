<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Order;
use AppBundle\Entity\Review;
use AppBundle\Type\OrderStatusType;
use Doctrine\ORM\Query\Expr\Join;

/**
 * OrderRepository.
 */
class OrderRepository extends AbstractListRepository
{

    /**
    * Получить список заказов
     *
     * @param array $options список 
     *
     * @return QueryBuilder
     */
    public function getItems($options)
    {
        $em = $this->getEntityManager();
        $select = $em->createQueryBuilder()
            ->select('c')
            ->from(Order::class, 'c')
            ->addOrderBy('c.cdate', 'DESC');

        if (isset($options['status']) && $options['status']) {
            $select =$select
                ->andWhere('c.status in (:status)')
                ->setParameter('status', $options['status']);
        }

        if (isset($options['date']) && $options['date']) {
            $select =$select
                ->andwhere('c.cdate BETWEEN :from AND :to')
                ->setParameter('from', $from = date('Y-m-d', strtotime($options['date'])))
                ->setParameter('to', $from.' 23:59:59');
        }

        if (isset($options['executor']) && $options['executor']) {
            $select =$select
                ->andWhere('c.executor in (:executor)')
                ->setParameter('executor', $options['executor']);
        }

        if (isset($options['user']) && $options['user']) {
            $select =$select
                ->andWhere('c.user IN (:user)')
                ->setParameter('user', $options['user']);
        }

        if (isset($options['item']) && $options['item']) {
            $select =$select
                ->andWhere('c.item IN (:item)')
                ->setParameter('item', $options['item']);
        }

        if (isset($options['archive'])) {

            $expr = $em->getExpressionBuilder();
            $subquery = $em->createQueryBuilder()
                           ->select('o.id')
                           ->from(Order::class, 'o')
                           ->leftJoin(Review::class, 'r', \Doctrine\ORM\Query\Expr\Join::WITH, 'r.order = o.id')
                           ->where('(r.id > 0 and o.status in (:dstatus)) or o.status in (:bstatus)')
                           ->getDQL();

            $select->setParameter('bstatus', OrderStatusType::_CANCEL)
                   ->setParameter('dstatus', OrderStatusType::_DONE);

            if ($options['archive']) {

                $select->andWhere($expr->in('c.id', $subquery));
            } else {

                $select->andWhere($expr->notIn('c.id', $subquery));
            }
        }

        return $select;
    }

    /**
    * Получить фильтр список товаров
     *
     * @param array $options список 
     *
     * @return array
     */
    public function getFilter($options)
    {
        $result['value'] = $options;
        unset($options['user']);
        $result['user'] = $this->getItems($options)
            ->join('c.user', 'u')
            ->select(array('u.id', 'u.name'))
            ->groupBy('u.id')
            ->orderBy('u.name')
            ->getQuery()
            ->getResult();

        $options = $result['value'];
        unset($options['executor']);
        $result['executor'] = $this->getItems($options)
            ->join('c.executor', 'u')
            ->select(array('u.id', 'u.brand'))
            ->groupBy('u.id')
            ->orderBy('u.brand')
            ->getQuery()
            ->getResult();

        $options = $result['value'];
        unset($options['item']);
        $result['item'] = $this->getItems($options)
            ->join('c.item', 'i')
            ->select(array('i.id', 'i.name'))
            ->groupBy('i.id')
            ->orderBy('i.name')
            ->getQuery()
            ->getResult();

        $options = $result['value'];
        unset($options['fstatus']);
        $result['fstatus'] = $this->getItems($options)
            ->select(array('c.status'))
            ->groupBy('c.status')
            ->orderBy('c.status')
            ->getQuery()
            ->getResult();

        return $result;
    }

}
