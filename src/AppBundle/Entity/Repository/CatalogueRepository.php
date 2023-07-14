<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\CmfRights;
use Doctrine\Common\Collections\Criteria;

/**
 * CatalogueRepository.
 *
 * Репозиторий, содержащий методы для работы со структурой сайта
 */
class CatalogueRepository extends TreeRepository
{
    /**
     * Получить запись по её URL.
     *
     * @param string $url URL записи
     *
     * @return object
     */
    public function getScriptByUrl($url)
    {
        $select = $this->createQueryBuilder('t')
            ->select()
            ->where('t.status = 1')
            ->andWhere('t.realStatus = 1');

        if (is_numeric($url)) {
            $select
                ->andWhere('t.realcatname = :url or t.id = :url')
                ->setMaxResults(1);
        } else {
            $select
                ->andWhere('t.realcatname = :url')
                ->setParameter('url', $url);
        }

        $query = $select->getQuery();

        return $query->getOneOrNullResult();
    }

    /**
     * Получение многомерного массива со структурой дерева.
     *
     * @param int   $rootId                    Элемент, относительно которого нужно построить дерево; по-умолчанию = 0, от корня дерева
     * @param int   $levels                    Глубина отрисовки дерева; по-умолчанию = 0 - всё дерево
     * @param int   $currentLevel              Текущий уровень. Не изменять - необходимо для рекурсии
     * @param array $extraFields               Дополнительные поля для выборки
     *
     * @return array
     */
    public function getTree($rootId = 0, $levels = 0, $currentLevel = 1, $extraFields = array())
    {
        $treeItems = array();
        $fields = array('t.id', 't.status', 't.name', 't.parentId', 't.lastnode', 't.ordering');

        foreach ($extraFields as $field) {
            $fields[] = $field;
        }

        $select = $this->createQueryBuilder('t')
            ->select($fields)
            ->where('t.realStatus>0 AND t.parentId = :parent_id')
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
     * Список предков из рубрик
     *
     * @param int $catalogueId Идентификатор конечного раздела
     *
     * @return array
     */
    public function getParents($catalogueId)
    {
        $result = [];

        $lastCatalogue = $this->findOneById($catalogueId);

        if ($lastCatalogue) {
            $select = $this->createQueryBuilder('c')
                ->select('c')
                ->where('c.leftMargin <= :leftMargin')
                ->setParameter('leftMargin', $lastCatalogue->getLeftMargin())
                ->andWhere('c.rightMargin >= :rightMargin')
                ->setParameter('rightMargin', $lastCatalogue->getRightMargin())
                ->andWhere('c.realStatus = 1')
                ->orderBy('c.depth', Criteria::ASC)
                ->getQuery();

            $result = $select->getResult();
        }
        
        return $result;
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
            ->select(array('t.id', 't.catname', 't.lastnode'))
            ->where('t.parentId = :parent_id')
            ->setParameter('parent_id', $parentId)
            ->getQuery();

        $rows = $select->getResult();

        foreach ($rows as $row) {
            $newCatname = $catname;

            $newCatname[] = $row['catname'] ? $row['catname'] : $row['id'];

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
                    't.parentId',
                    'CASE WHEN LENGTH(t.catname) > 0 THEN t.catname ELSE t.id END as catname',
                ))
                ->where('t.id = :id');

            while ($catId) {
                $selectClone = clone $select;

                $query = $selectClone->setParameter('id', $catId)->getQuery();

                $row = $query->setMaxResults(1)->getOneOrNullResult();
                
                if ($row) {

                    $newCatnameForChild[] = $row['catname'];

                    $newCatname[] = $row['catname'];

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
}
