<?php

namespace AppBundle\Doctrine;

use AppBundle\Entity\CmfRights;
use AppBundle\Entity\Privilege;
use AppBundle\Entity\RoleGroup;
use AppBundle\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Yaml\Yaml;

/**
 * Класс для генерации security-конфига с доступами
 */
class SecurityGeneratorListener implements EventSubscriber
{
    /**
     * @var TokenStorage класс, где хранится текущий токен
     */
    protected $tokenStorage;
    
    /**
     * @var EntityManager класс для работы с моделями
     */
    protected $entityManager;

    /**
     * Constructor
     *
     * @param TokenStorage $tokenStorage
     * @param EntityManager $entityManager
     */
    public function __construct($tokenStorage, $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents()
    {
        return ['postPersist', 'postRemove', 'postUpdate'];
    }
    
    /**
     * Событие, вызываемое после добавления элемента
     *
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof User ||
            $entity instanceof Privilege ||
            $entity instanceof RoleGroup
        ) {
            $this->generateSecurityYML();
        }
    }
    
    /**
     * Событие, вызываемое после обновления элемента
     *
     * @param LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        
        if ($entity instanceof User ||
            $entity instanceof Privilege ||
            $entity instanceof RoleGroup
        ) {
            $this->generateSecurityYML();
        }
    }
    
    /**
     * Событие, вызываемое после удаления элемента
     *
     * @param LifecycleEventArgs $args
     */
    public function postRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof User ||
            $entity instanceof Privilege ||
            $entity instanceof RoleGroup
        ) {
            $this->generateSecurityYML();
        }
    }
    
    /**
     * Генерация security-конфига с доступами, и сброс таблицы с правами
     */
    public function generateSecurityYML()
    {
        global $kernel;
        
        $this->entityManager->flush();
        
        $ymlArray = [];
        
        $cmfRightsRepo = $this->entityManager->getRepository(CmfRights::class);
        $result = $cmfRightsRepo->getActiveRolesWithSections();
        
        $roleGroupEntity = $this->entityManager->getRepository(RoleGroup::class);
        $roleGroupArray = $roleGroupEntity->findAll();
        
        $roleGroups = [];

        foreach ($roleGroupArray as $row) {
            $roleGroups[] = "ROLE_" . $row->getId();
        }
        
        $rights = [
            "/admin/login" => ["IS_AUTHENTICATED_ANONYMOUSLY"],
            "/admin/core" => ["IS_AUTHENTICATED_FULLY"],
            "/login" => ["IS_AUTHENTICATED_ANONYMOUSLY"],
            "/register" => ["IS_AUTHENTICATED_ANONYMOUSLY"],
            "/cabinet" => ["IS_AUTHENTICATED_FULLY"],
            "/logout" => ["IS_AUTHENTICATED_FULLY"],
            "/admin" => $roleGroups,
            "/admin/dashboard" => $roleGroups,
        ];
        
        foreach ($result as $row) {
            if ($row["url"] != '') {
                $url = $row["url"];

                if (preg_match("/^(\/admin.*)list$/", $url, $matches)) {
                    $url = $matches[1];
                }

                $rights[$url][] = "ROLE_" . $row["roles_group_id"];
            } elseif ($row["realcatname"] != '') {
                $rights["/" . trim($row["realcatname"], "/") . "/"][] = "ROLE_" . $row["roles_group_id"];
            }
        }
        
        $rights["/admin/"] = ["ROLE_NO_ACCESS"];
        
        foreach ($rights as $path => $roles) {
            $ymlArray["security"]["access_control"][] = [
                "path" => "^".$path,
                "roles" => array_unique($roles),
            ];
        }
        
        $yaml = Yaml::dump($ymlArray, 3);
        
        $fs = new Filesystem();
        
        $fs->dumpFile($kernel->getRootDir().'/config/security/access_control_tree.yml', $yaml);
        
        $cmfRightsRepo->cleanRightsTable();
        
        $token = $this->tokenStorage->getToken();

        if ($token && $user = $token->getUser()) {
            if (is_object($user) && $user->getUserId()) {
                $userRepo = $this->entityManager->getRepository(User::class);
                $userRepo->initRights($user->getRoleGroupIds(), $user->getRGHash());
            }
        }
    }
}
