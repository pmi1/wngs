<?php

namespace AppBundle\EventListener;

use FOS\ElasticaBundle\Event\TransformEvent;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Catalogue;

/**
 * Слушатель для добавления дополнительных полей в индексы эластика. Срабатывает в момент индексации данных.
 *
 *
 */
class ElasticPropertyListener implements EventSubscriberInterface
{
    private $container;
    /**
     * ElasticPropertyListener constructor.
     *
     * @param Container $container
     * @param EntityManager $manager
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Добавляем дополнительные поля в индекс клиник
     *
     * @param TransformEvent $event
     */
    public function addCustomProperty(TransformEvent $event)
    {
        $document = $event->getDocument();
        //$document->set('allCatalogues2', $event->getObject());

        if ($document->has('allCatalogues')) {
            $is = $document->get('allCatalogues');
            $results = [];
            if (is_array($is) && count($is)) {
                $catalogueRepo = $this->container->get('doctrine')->getEntityManager()->getRepository(Catalogue::class);
                foreach ($is as $i) {
                    $results[$i['id']] = $i;
                    $catalogueParents = $catalogueRepo->getParents($i['id']);

                    foreach ($catalogueParents as $v) {
                        $results[$v->getId()] = ['id'=>$v->getId()];
                    }
                 }
            }

            $document->set('allCatalogues', array_values($results));
        }
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            TransformEvent::POST_TRANSFORM => 'addCustomProperty',
        );
    }
}
