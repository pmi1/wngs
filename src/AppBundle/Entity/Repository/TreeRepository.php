<?php

namespace AppBundle\Entity\Repository;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityRepository;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;

/**
 * TreeRepository.
 *
 * Репозиторий, содержащий дефолтные методы для работы с древовидными структурами
 */
class TreeRepository extends EntityRepository
{
    /**
     * Корень клиентской части сайта.
     */
    protected $clientNodeId = 0;

    /**
     * Собираем многомерный массив со структурой дерева.
     *
     * @param int   $rootId       Элемент, относительно которого нужно построить дерево; по-умолчанию = 0, от корня дерева
     * @param int   $levels       Глубина отрисовки дерева; по-умолчанию = 0 - всё дерево
     * @param int   $currentLevel Текущий уровень. Не изменять - необходимо для рекурсии
     * @param array $extraFields  Дополнительные поля для выборки
     *
     * @return array
     */
    public function getTree($rootId = 0, $levels = 0, $currentLevel = 1, $extraFields = array())
    {
        $treeItems = array();
        $fields = array('t.id', 't.status', 't.name', 't.parentId', 't.lastnode', 't.ordering');

        foreach ($extraFields as $field) {
            $fields[] = 't.'.$field;
        }

        $select = $this->createQueryBuilder('t')
            ->select($fields)
            ->where('t.parentId = :parent_id')
            ->setParameter('parent_id', $rootId)
            ->orderBy('t.ordering', Criteria::ASC)
            ->getQuery();

        $rows = $select->getResult();

        foreach ($rows as $row) {
            $id = $row['id'];

            $treeItems[$id] = $row;

            if (!$row['lastnode'] && ($currentLevel < $levels || !$levels)) {
                $subItems = $this->getTree($id, $levels, $currentLevel + 1, $extraFields);

                if (count($subItems)) {
                    $treeItems[$id]['sub_items'] = $subItems;
                }

                unset($subItems);
            }
        }

        return $treeItems;
    }

    /**
     * Собираем многомерный массив со структурой дерева.
     *
     * @param int $rootId корневой элемент, относительно которого нужно получить дерево
     *
     * @return ProxyQuery builder object
     */
    public function getDatagridTree($rootId = 0)
    {
        $qb = $this->createQueryBuilder('t')
            ->select('t')
            ->orderBy('t.leftMargin', Criteria::ASC);

        if ($rootId > 0) {
            $qbStart = $this->createQueryBuilder('t')
                ->select(array(
                    't.leftMargin',
                    't.rightMargin',
                    't.parentId',
                ))
                ->where('t.id = :id')
                ->setParameter('id', $rootId);

            $qStart = $qbStart->getQuery();
            $startRow = $qStart->getSingleResult();
            $leftMargin = $startRow['leftMargin'];
            $rightMargin = $startRow['rightMargin'];

            $qb->where('t.leftMargin > :left_margin AND t.rightMargin < :right_margin')
                ->setParameters(['left_margin' => $leftMargin, 'right_margin' => $rightMargin]);
        }

        return new ProxyQuery($qb);
    }

    /**
     * Расчет полного пути для заданного элемента дерева.
     *
     * @param int|array $ids идентификатор записи
     */
    public function rebuildRealCatnameForId($ids)
    {
        foreach ((array) $ids as $id) {
            $newCatname = array();
            $newCatnameForChild = array();

            $catId = $id;

            $select = $this->createQueryBuilder('t')
                ->select(array(
                    't.id',
                    't.isExcludePath',
                    't.parentId',
                    'CASE WHEN LENGTH(t.catname) > 0 THEN t.catname ELSE t.id END as catname',
                ))
                ->where('t.id = :id');

            while ($catId) {
                $selectClone = clone $select;

                $query = $selectClone->setParameter('id', $catId)->getQuery();

                $row = $query->setMaxResults(1)->getOneOrNullResult();
                
                if ($row) {
                    if ($row['id'] == $this->clientNodeId) {
                        break;
                    }

                    if (!$row['isExcludePath']) {
                        $newCatnameForChild[] = $row['catname'];
                    }

                    if ($catId == $id || !$row['isExcludePath']) {
                        $newCatname[] = $row['catname'];
                    }

                    $catId = (int) $row['parentId'];
                } else {
                    $catId = 0;
                }
            }

            $qb = $this->createQueryBuilder('t');
            $query = $qb->update()
                ->set('t.realcatname', $qb->expr()->literal(implode('/', array_reverse($newCatname))))
                ->where('t.id = :id')
                ->setParameter('id', $id)
                ->getQuery();

            $query->execute();

            // Пересчитаем полные пути потомков
            $this->rebuildRealCatname($id, array_reverse($newCatnameForChild));
        }
    }

    /**
     * Расчет статуса раздела и его потомков (с учётом всех предков).
     *
     * @param int $id Идентификатор записи
     */
    public function rebuildRealStatusForId($id)
    {
        $realstatus = $this->calcRealStatus($id);

        $query = $this->createQueryBuilder('t')
            ->update()
            ->set('t.realStatus', $realstatus)
            ->where('t.id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        $query->execute();

        $this->setTreeRealStatus($id, $realstatus);
    }

    /**
     * При добавлении раздела его предок перестаёт быть последним в дереве.
     *
     * @param int $id Идентификатор записи
     */
    public function initLastnodeForId($id)
    {
        $item = $this->find($id);
        $parentId = $item->getParentId();

        if ($parentId) {
            $query = $this->createQueryBuilder('t')
                ->update()
                ->set('t.lastnode', 0)
                ->where('t.id = :id')
                ->setParameter('id', $parentId)
                ->getQuery();

            $query->execute();
        }
    }

    /**
     * При удалении раздела проверяем, не стал ли предок последним в дереве.
     *
     * @param int $id Идентификатор записи
     */
    public function recheckLastnodeForId($id)
    {
        $item = $this->find($id);
        $parentId = $item->getParentId();

        $select = $this->createQueryBuilder('t')
            ->select('count(t.id)')
            ->where('t.parentId = :parent_id')
            ->setParameter('parent_id', $parentId)
            ->getQuery();

        $childcount = $select->getSingleScalarResult();

        if (1 === $childcount) {
            $query = $this->createQueryBuilder('t')
                ->update()
                ->set('t.lastnode', 1)
                ->where('t.id = :id')
                ->setParameter('id', $parentId)
                ->getQuery();

            $query->execute();
        }
    }

    /**
     * Каскадное удаление потомков удалённого раздела.
     *
     * @param int $id Идентификатор записи
     */
    public function deleteSubTree($id)
    {
        $select = $this->createQueryBuilder('t')
            ->select(array('t.id'))
            ->where('t.parentId = :parent_id')
            ->setParameter('parent_id', $id)
            ->getQuery();

        $rows = $select->getResult();

        foreach ($rows as $row) {
            $item = $this->find($row['id']);
            $this->_em->remove($item);
            $this->_em->flush();
        }
    }

    /**
     * При добавлении раздела рассчитываем сортировку для вставки в конец списка.
     *
     * @param int $parentId Идентификатор предка
     *
     * @return int
     */
    public function getNextOrdering($parentId)
    {
        $select = $this->createQueryBuilder('t')
            ->select('MAX(t.ordering)')
            ->where('t.parentId = :parent_id')
            ->setParameter('parent_id', $parentId)
            ->getQuery();

        $ordering = $select->getSingleScalarResult();

        return $ordering ? $ordering + 1 : 1;
    }

    /**
     * Рассчитываем глубину, на которой находится раздел в дереве.
     *
     * @param int $id Идентификатор записи
     *
     * @return int
     */
    public function setDepthForId($id)
    {
        $depth = 1;
        $item = $this->find($id);
        $parentId = (int) $item->getParentId();

        while ($parentId > 0) {
            ++$depth;

            $select = $this->createQueryBuilder('t')
                ->select(array(
                    't.parentId',
                ))
                ->where('t.id = :id')
                ->setParameter('id', $parentId);

            $query = $select->getQuery();

            $parentId = $query->getSingleScalarResult();
        }

        $query = $this->createQueryBuilder('t')
            ->update()
            ->set('t.depth', $depth)
            ->where('t.id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        $query->execute();
    }

    /**
     * Пересчет margin для nested set.
     */
    public function RebuildTreeOrdering()
    {
        $ord = 0;
        $parentId = 0;

        $this->runTreeOrdering($ord, $parentId);
    }
    
    /**
     * Метод для пересчета полного пути потомков.
     *
     * @param int    $parentId Идентификатор предка
     * @param string $catname  Путь, полученный от всех предков
     */
    protected function rebuildRealCatname($parentId, $catname)
    {
        $select = $this->createQueryBuilder('t')
            ->select(array('t.id', 't.catname', 't.lastnode', 't.isExcludePath'))
            ->where('t.parentId = :parent_id')
            ->setParameter('parent_id', $parentId)
            ->getQuery();

        $rows = $select->getResult();

        foreach ($rows as $row) {
            $newCatname = $catname;

            if (!$row['isExcludePath']) {
                $newCatname[] = $row['catname'] ? $row['catname'] : $row['id'];
            }

            $qb = $this->createQueryBuilder('t');
            $query = $qb->update()
                ->set('t.realcatname', $qb->expr()->literal(implode('/', $newCatname)))
                ->where('t.id = :id')
                ->setParameter('id', $row['id'])
                ->getQuery();

            $query->execute();

            if (0 === $row['lastnode']) {
                $this->rebuildRealCatname($row['id'], $newCatname);
            }

            unset($newCatname);
        }
    }

    /**
     * Расчет статуса для всех потомков указанного элемента.
     *
     * @param int $id     Идентификатор записи
     * @param int $status Статус записи
     */
    protected function setTreeRealStatus($id, $status)
    {
        $select = $this->createQueryBuilder('t')
            ->select(
                array(
                't.id',
                't.status', )
            )
            ->where('t.parentId = :parent_id')
            ->setParameter('parent_id', $id)
            ->getQuery();

        $rows = $select->getResult();

        foreach ($rows as $row) {
            if ($row['status']) {
                $this->setTreeRealStatus($row['id'], $status);
            }

            $update = $this->createQueryBuilder('t')
                ->update();

            if ($status) {
                $update->set('t.realStatus', 't.status');
            } else {
                $update->set('t.realStatus', 0);
            }

            $update->where('t.id = :id')
                ->setParameter('id', $row['id']);

            $query = $update->getQuery();

            $query->execute();
        }
    }

    /**
     * Расчет статуса записи с учётом её предков.
     *
     * @param int $id Идентификатор записи
     *
     * @return int
     */
    protected function calcRealStatus($id)
    {
        $pid = $id;
        $realstate = 1;

        while ($pid > 0) {
            $select = $this->createQueryBuilder('t')
                ->select(array(
                    't.status',
                    't.parentId',
                ))
                ->where('t.id = :id')
                ->setParameter('id', $pid);

            $query = $select->getQuery();

            $row = $query->setMaxResults(1)->getOneOrNullResult();
            
            if ($row) {
                if ($row['status'] != 1) {
                    $realstate = 0;
                }

                $pid = $row['parentId'];
            } else {
                $pid = 0;
            }
        }

        return $realstate;
    }

    /**
     * Пересчет границ для nested set.
     *
     * @param int $ord      Инкремент
     * @param int $parentId Идентификатор предка
     */
    protected function runTreeOrdering(&$ord, $parentId)
    {
        $select = $this->createQueryBuilder('t')
            ->select(array('t.id'))
            ->where('t.parentId = :parent_id')
            ->setParameter('parent_id', $parentId)
            ->orderBy('t.ordering', Criteria::ASC)
            ->getQuery();

        $rows = $select->getResult();

        foreach ($rows as $row) {
            ++$ord;

            $leftMargin = $ord;

            $this->runTreeOrdering($ord, $row['id']);

            ++$ord;

            $rightMargin = $ord;

            $query = $this->createQueryBuilder('t')
                ->update()
                ->set('t.leftMargin', $leftMargin)
                ->set('t.rightMargin', $rightMargin)
                ->where('t.id = :id')
                ->setParameter('id', $row['id'])
                ->getQuery();

            $query->execute();
        }
    }
}
