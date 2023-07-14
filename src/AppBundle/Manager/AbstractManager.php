<?php

namespace AppBundle\Manager;

use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Абстрактный сервис менеджер
 *
 *
 */
abstract class AbstractManager implements ContainerAwareInterface
{
    use ContainerAwareTrait;
    
    /**
     * @param string $className
     *
     * @return ObjectRepository
     */
    protected function getRepository($className)
    {
        return $this->container->get('doctrine')->getRepository($className);
    }
}
