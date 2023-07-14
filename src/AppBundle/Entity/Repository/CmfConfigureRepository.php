<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\CmfConfigure;
use Doctrine\ORM\EntityRepository;

/**
 * CmfConfigureRepository.
 */
class CmfConfigureRepository extends EntityRepository
{
    /**
     * getTableConfigure - возвращает массив настройки вывода полей в списке для конкретного пользователя,
     *       если настроек нет - вернет пустой массив.
     *
     * @param int    $userId пользователь, для которого получаем настройки
     * @param string $script название класс Entity
     *
     * @return array
     */
    public function getTableConfigure($userId, $script)
    {
        $result = array();
        $select = $this->createQueryBuilder('t')
            ->select(array('t.fieldName', 't.isVisuality'))
            ->where('t.userId = :userId and t.scriptName = :script')
            ->setParameters(array('userId' => $userId, 'script' => $script))
            ->orderBy('t.ordering')
            ->getQuery();

        $rows = $select->getResult();

        foreach ($rows as $row) {
            $result[$row['fieldName']] = $row;
        }

        return $result;
    }

    /**
     * getFieldsToDisplay - возвращает список полей для переданной Entity, исключая служебные поля для визивика.
     *
     * @param string $script название Entity
     *
     * @return array
     */
    public function getFieldsToDisplay($script)
    {
        $em = $this->getEntityManager();
        $dataManager = $em->getClassMetadata('AppBundle:' . $script);
        $fields = array_merge($dataManager->getFieldNames(), $dataManager->getAssociationNames());
        return array_filter($fields, function ($var) {
            return !(self::strEndsWith($var, 'Type') || self::strEndsWith($var, '.type') || self::strEndsWith($var, 'Raw') || self::strEndsWith($var, '.raw') || $var === 'deletedAt');
        });
    }

    /**
     * strEndsWith - возвращает true, если $haystack оканчивается на $needle, иначе false.
     *
     * @param string $haystack строка, в которой ищем
     * @param string $needle   искомая подстрока
     *
     * @return bool
     */
    public static function strEndsWith($haystack, $needle)
    {
        return substr_compare($haystack, $needle, -strlen($needle)) === 0;
    }

    /**
     * getConfigureFields - возвращает массив настройки вывода полей в списке для конкретного пользователя,
     *       если настроек нет - вернет список полей для Entity c первыми 3-ми активными.
     *
     * @param int    $userId пользователь, для которого получаем настройки
     * @param string $script название класс Entity
     *
     * @return array
     */
    public function getConfigureFields($userId, $script)
    {
        $result = array();
        //выбираем все возможные для отображения поля
        $fieldsDisplay = $this->getFieldsToDisplay($script);
        $fieldsHash = $this->getTableConfigure($userId, $script);

        foreach ($fieldsDisplay as $i) {
            $result[$i] = isset($fieldsHash[$i]) ? $fieldsHash[$i] :
                array('fieldName' => $i, 'isVisuality' => false);
        }

        //Если настроек нет вообще, то отображаем 3 первых поля
        if (count($fieldsHash) === 0 && count($result) > 0) {
            $is = array_keys($result);

            foreach ($is as $k => $i) {
                if ($k < 3) {
                    $result[$i]['isVisuality'] = true;
                } else {
                    break;
                }
            }
        }

        return $result;
    }

    /**
     * setConfigureFields - сохраняет настройки вывода полей в списке для конкретного пользователя.
     *
     * @param int    $userId пользователь, для которого сохраняем настройки
     * @param string $script название класса Entity
     * @param array  $fields массив массивов вида array('fieldName' => '<Название поля>', 'isVisuality' => '0|1')
     */
    public function setConfigureFields($userId, $script, $fields)
    {
        $entity = new CmfConfigure();
        $entityManager = $this->getEntityManager();

        $qb = $entityManager->createQueryBuilder()
                    ->delete(CmfConfigure::class, 't')
                    ->where('t.userId = :userId and t.scriptName = :script')
                    ->setParameters(array('userId' => $userId, 'script' => $script))
                    ->getQuery()
                    ->execute();

        foreach ($fields as $v) {
            $entity->setUserId($userId);
            $entity->setScriptName($script);
            $entity->setFieldName($v['fieldName']);
            $entity->setIsVisuality($v['isVisuality']);
            $entityManager->merge($entity);
            $entityManager->flush();
        }
    }
}
