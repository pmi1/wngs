<?php

namespace AppBundle\Doctrine;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

/**
 * Класс для хэширования пользовательского пароля
 */
class HashPasswordListener implements EventSubscriber
{
    /**
     * @var UserPasswordEncoder Метод хэширования пароля
     */
    private $passwordEncoder;
    
    /**
     * @param UserPasswordEncoder $passwordEncoder
     */
    public function __construct(UserPasswordEncoder $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents()
    {
        return ['prePersist', 'preUpdate'];
    }
    
    /**
     * Хэширование пароля в соответствии с методом, заданным в конфиге.
     *
     * @param User $entity
     *
     * @return bool
     */
    private function encodePassword(User $entity)
    {
        $newPassword = $entity->getPlainPassword();
        
        if (!strlen($newPassword)) {
            return false;
        }
        
        $encoded = $this->passwordEncoder->encodePassword(
            $entity,
            $newPassword
        );
        $entity->setPassword($encoded);
        
        return true;
    }
    
    /**
     * Событие, вызываемое перед добавлением пользователя.
     *
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof User) {
            return;
        }

        $this->encodePassword($entity);
    }

    /**
     * Событие, вызываемое перед обновлением пользователя.
     *
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof User) {
            return;
        }

        if ($this->encodePassword($entity)) {
            $em = $args->getEntityManager();
            $meta = $em->getClassMetadata(get_class($entity));
            $em->getUnitOfWork()->recomputeSingleEntityChangeSet($meta, $entity);
        }
    }
}
