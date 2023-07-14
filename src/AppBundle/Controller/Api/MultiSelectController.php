<?php

namespace AppBundle\Controller\Api;

use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * API выборка через несколько связей любую сущность, которая это поддерживает
 *
 *
 */
class MultiSelectController extends Controller
{
    /**
    * @Route("/multiselect/{adminClass}{trailingSlash}{params}", name="multiselect", defaults={"trailingSlash" = "/"}, requirements={"adminClass": "\w+", "trailingSlash" = "[/]{0,1}", "params": ".*"})
    */
    public function selectAction($adminClass, $params)
    {
        $adminName = '\\AppBundle\\Admin\\' . $adminClass;

        /** @var object $admin */
        $admin = new $adminName;

        $result = array();
        $objects = $admin->getBindingModel();

        $ifFull = true;
        $parentId = 0;
        $ids = explode(';', $params);

        foreach ($objects as $object) {
            /** @var EntityRepository $repository */
            $repository = $this->getDoctrine()->getRepository($object['class']);
            $current = array_shift($ids);

            if (is_numeric($parentId)) {
                $queryBuilder = $repository->createQueryBuilder('p');

                if ($parentId > 0) {
                    $queryBuilder->where('p.'.$object['parentField'].'=:parentId')->setParameter('parentId', $parentId);
                }

                $result['selects'][$object['name']]['current'] = $current >0? $current:0;
                $result['selects'][$object['name']]['label'] = isset($object['label'])?$object['label']:$object['name'];

                foreach ($queryBuilder->getQuery()->getResult() as $record) {
                    $result['selects'][$object['name']]['data'][] = array($record->getId(), $record->__toString());
                }
            } else {
                $ifFull = false;
            }

            $parentId = $current;
        }

        if ($ifFull) {
            $result['full'] = 1;
        }

        return new JsonResponse($result);
    }
}
