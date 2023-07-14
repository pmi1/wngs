<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\CmfRights;
use AppBundle\Entity\CmfScript;
use Doctrine\Common\Collections\Criteria;

/**
 * CmfScriptRepository.
 *
 * Репозиторий, содержащий методы для работы со структурой сайта
 */
class CmfScriptRepository extends TreeRepository
{
    /**
     * @var int Корень клиентской части сайта
     */
    protected $clientNodeId = 2;

    /**
     * @var int|null Left Margin корня клиентской части
     */
    protected $clientLeftMargin = null;

    /**
     * @var int|null Right Margin корня клиентской части
     */
    protected $clientRightMargin = null;

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
     * Получение многомерного массива со структурой дерева с учётом прав.
     *
     * @param int   $cmfRoleGroupCombinationId Права доступа
     * @param int   $rootId                    Элемент, относительно которого нужно построить дерево; по-умолчанию = 0, от корня дерева
     * @param int   $levels                    Глубина отрисовки дерева; по-умолчанию = 0 - всё дерево
     * @param int   $currentLevel              Текущий уровень. Не изменять - необходимо для рекурсии
     * @param array $extraFields               Дополнительные поля для выборки
     *
     * @return array
     */
    public function getTreeAndCheckAccess($cmfRoleGroupCombinationId = 0, $rootId = 0, $levels = 0, $currentLevel = 1, $extraFields = array())
    {
        $treeItems = array();
        $fields = array('t.id', 't.status', 't.name', 't.parentId', 't.lastnode', 't.ordering', 't.realcatname');

        foreach ($extraFields as $field) {
            $fields[] = 't.'.$field;
        }

        $select = $this->getEntityManager()->createQueryBuilder()
            ->select($fields)
            ->from(CmfScript::class, 't')
            ->where('t.realStatus>0 AND t.parentId = :parent_id AND (r.isRead>0 AND r.cmfRoleGroupCombinationId = :cmfRoleGroupCombinationId or r.id IS NULL)')
            ->leftJoin(CmfRights::class, 'r', 'WITH', 'r.script = t.id')
            ->setParameter('parent_id', $rootId)
            ->setParameter('cmfRoleGroupCombinationId', $cmfRoleGroupCombinationId)
            ->orderBy('t.ordering', Criteria::ASC)
            ->getQuery();

        $rows = $select->getResult();

        foreach ($rows as $row) {
            $id = $row['id'];
            $treeItems[$id] = $row;

            if (!$row['lastnode'] && ($currentLevel < $levels || !$levels)) {
                $subItems = $this->getTreeAndCheckAccess($cmfRoleGroupCombinationId, $id, $levels, $currentLevel + 1, $extraFields);

                if (count($subItems)) {
                    $treeItems[$id]['sub_items'] = $subItems;
                }

                unset($subItems);
            }
        }

        return $treeItems;
    }

    /**
     * Относится ли раздел к клиентской части?
     *
     * @param object $object Объект записи
     *
     * @return bool
     */
    public function isClientSection($object)
    {
        $this->initClientMargins();

        return (($object->getLeftMargin() > $this->clientLeftMargin)) && (($object->getRightMargin() < $this->clientRightMargin));
    }

    /**
     * Инициализация Left Margin и Right Margin корня клиентской части.
     */
    public function initClientMargins()
    {
        if (!isset($this->clientLeftMargin) || !isset($this->clientRightMargin)) {
            $qb = $this->createQueryBuilder('t')
                    ->select(array(
                        't.leftMargin',
                        't.rightMargin',
                    ))
                    ->where('t.id = :id')
                    ->setParameter('id', $this->clientNodeId);

            $q = $qb->getQuery();
            $row = $q->getSingleResult();
            $this->clientLeftMargin = $row['leftMargin'];
            $this->clientRightMargin = $row['rightMargin'];
        }
    }
        
    /**
     * Получить Left Margin корня клиентской части
     *
     * @return integer
     */
    public function getClientLeftMargin()
    {
        return $this->clientLeftMargin;
    }
    
    /**
     * Получить Right Margin корня клиентской части
     *
     * @return integer
     */
    public function getClientRightMargin()
    {
        return $this->clientRightMargin;
    }
        
    /**
     * Формирование хлебных крошек из дерева сайта
     *
     * @param string $firstArticle Псевдоним начального раздела
     * @param string $lastArticle Псевдоним конечного раздела
     * @param int $lastArticle Идентификатор конечного раздела
     *
     * @return array
     */
    public function generateBreadCrumbs($firstArticle, $lastArticle, $lastScriptId)
    {
        $result = [];
        $depthOfMain = null;
        
        if ($lastArticle) {
            $lastScript = $this->findOneByArticle($lastArticle);
        } else {
            $lastScript = $this->findOneById($lastScriptId);
        }
        if ($lastScript) {
            $select = $this->createQueryBuilder('c')
                ->select('c')
                ->where('c.leftMargin <= :leftMargin')
                ->setParameter('leftMargin', $lastScript->getLeftMargin())
                ->andWhere('c.rightMargin >= :rightMargin')
                ->setParameter('rightMargin', $lastScript->getRightMargin())
                ->andWhere('c.realStatus = 1')
                ->orderBy('c.depth', Criteria::ASC)
                ->getQuery();

            $rows = $select->getResult();
            foreach ($rows as $row) {
                if ($firstArticle == $row->getArticle()) {
                    $depthOfMain = $row->getDepth();
                }
                
                if ($depthOfMain !== null && $row->getIsExcludePath() == 0 || (($row->getIsExcludePath() == 1) && $firstArticle == $row->getArticle())) {
                    $result[] = $row;
                }
            }
        }
        
        return $result;
    }
}
