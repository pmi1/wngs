<?php

namespace AppBundle\Security\Handler;

use AppBundle\Entity\CmfRights;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Security\Handler\SecurityHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Security-класс для проверки прав пользователя в административной части сайта
 */
class RoleSecurityHandler implements SecurityHandlerInterface
{
    /**
     * @var AuthorizationCheckerInterface|SecurityContextInterface
     */
    protected $authorizationChecker;

    /**
     * @var array
     */
    protected $superAdminRoles;

    /**
     * @var array
     */
    protected $privilegeMapper;

    /**
     * @param AuthorizationCheckerInterface|SecurityContextInterface $authorizationChecker
     * @param array $superAdminRoles
     */
    public function __construct($authorizationChecker, array $superAdminRoles)
    {
        if (!$authorizationChecker instanceof AuthorizationCheckerInterface && !$authorizationChecker instanceof SecurityContextInterface) {
            throw new \InvalidArgumentException('Argument 1 should be an instance of Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface or Symfony\Component\Security\Core\SecurityContextInterface');
        }

        $this->authorizationChecker = $authorizationChecker;
        $this->superAdminRoles = $superAdminRoles;
        $this->privilegeMapper = array(
            "LIST" => "is_read",
            "VIEW" => "is_read",
            "CREATE" => "is_insert",
            "EDIT" => "is_write",
            "DELETE" => "is_delete",
            "EXPORT" => "is_read",
            "ALL" => "is_write",
        );
    }

    /**
     * {@inheritdoc}
     */
    public function isGranted(AdminInterface $admin, $attributes, $object = null)
    {
        $routes = $admin->getRoutes();
        $request = Request::createFromGlobals();
        $router = $admin->getConfigurationPool()->getContainer()->get('router')->getContext();
        $baseUrl = $request->getBaseUrl();
        $router->setBaseUrl("");
        
        try {
            $url = $admin->generateUrl($routes->getBaseCodeRoute() . '.list', array());
        } catch (\Exception $e) {
            $url = $admin->getRequest()->getRequestUri();
        }
        
        $router->setBaseUrl($baseUrl);
        
        $tempArray = explode("?", $url);
        
        $url = $tempArray[0];
        
        $repo = $admin->getConfigurationPool()->getContainer()->get('doctrine')->getRepository(CmfRights::class);
        $user = $admin->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        
        if (!is_array($attributes)) {
            $attributes = array($attributes);
        }
        
        foreach ($attributes as $attr) {
            if (isset($this->privilegeMapper[$attr]) && is_object($user)) {
                $isGranted = $repo->isGranted($url, $user->getRGHash(), $this->privilegeMapper[$attr]);

                if ($isGranted) {
                    return true;
                }
            }
        }
        
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getBaseRole(AdminInterface $admin)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function buildSecurityInformation(AdminInterface $admin)
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function createObjectSecurity(AdminInterface $admin, $object)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function deleteObjectSecurity(AdminInterface $admin, $object)
    {
    }
}
