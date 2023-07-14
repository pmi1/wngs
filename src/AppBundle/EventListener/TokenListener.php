<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Класс инициализирующий права для текущего пользователя
 */
class TokenListener
{
    /**
     * @var TokenStorage tokenStorage
     */
    protected $tokenStorage;
    
    /**
     * @var EntityManager entityManager
     */
    protected $entityManager;

    /**
     * Constructor
     *
     * @param TokenStorage $tokenStorage
     * @param EntityManager $entityManager
     */
    public function __construct(TokenStorage $tokenStorage, EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * Событие, вызываемое перед входом в контроллер
     *
     * @param FilterControllerEvent $event
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        if (!is_array($controller)) {
            return;
        }
        
        $token = $this->tokenStorage->getToken();

        if ($token && $user = $token->getUser()) {
            if (is_object($user) && $user->getUserId()) {
                $userRepo = $this->entityManager->getRepository(User::class);
                $userRepo->initRights($user->getRoleGroupIds(), $user->getRGHash());
            }
        } else {
            /*$userRepo = $this->entityManager->getRepository(User::class);
            $user = $userRepo->find(1); // TODO: Если пользователя с ID 1 нет, то выбивает ошибку, надо пофиксить
            $userRepo->initRights($user->getRoleGroupIds(), $user->getRGHash());*/
        }
    }
}
