<?php

namespace AppBundle\Helper;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Абстракстный сервис хелпер
 *
 *
 */
abstract class AbstractHelper implements ContainerAwareInterface
{
    use ContainerAwareTrait;
    
    /**
     * @param string $className класс Entity
     */
    public function getRepository($className)
    {
        return $this->container->get('doctrine')->getRepository($className);
    }
}
