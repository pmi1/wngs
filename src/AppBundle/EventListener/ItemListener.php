<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Item;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Класс, обновляющий активность каталога дизайнера
 */
class ItemListener
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function postUpdate(Item $item, LifecycleEventArgs $event)
    {

        if ($user = $item->getUser()) {

            $em = $event->getEntityManager();

            $result = [];
            $sales = [$this->container->getParameter('sale_id')
                            , $this->container->getParameter('flash_sale_id')
                            , $this->container->getParameter('sale_predictor_id')];

            if ($user->getItems()) {

                foreach ($user->getItems() as $i) {

                    foreach ($sales as $s) {

                        if ($i->getAllSelections()->containsKey($s)) {

                            $result[$s] = $s;
                        }
                    }
                }
            }

            $user->setActiveCatalogue(count($result) == 3);
            $em->persist($user);
            $em->flush();

        }
    }
}