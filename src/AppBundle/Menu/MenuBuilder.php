<?php

namespace AppBundle\Menu;

use AppBundle\Entity\CmfScript;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Knp\Menu\MenuItem;
use Sonata\AdminBundle\Admin\Pool;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

/**
 * Class MenuBuilder
 *
 * Класс, перекрывающий стандартное меню сонаты
 */
class MenuBuilder
{
    /**
     * @var Pool
     */
    private $pool;
    
    /**
     * @var FactoryInterface
     */
    private $factory;

    /*
     * @var EntityManager
     */
    protected $em;
    
    /*
     * @var Router
     */
    protected $router;
    
    /*
     * @var UrlMatcher для проверки маршрутов
     */
    protected $matcher;
        
    /*
     * @var TokenStorageInterface|SecurityContextInterface хранилище токенов
     */
    protected $tokenStorage;
    
    /**
     * @var appDevDebugProjectContainer|appProdProjectContainer Контейнер
     */
    private $container;
    
    /**
     * @var string текущий админ-скрипт
     */
    private $sonataAdmin;

    /**
     * @param Pool $pool
     * @param FactoryInterface $factory
     * @param EntityManager $manager
     * @param Router $router
     * @param TokenStorageInterface $tokenStorage
     * @param appDevDebugProjectContainer|appProdProjectContainer $container
     */
    public function __construct(Pool $pool, FactoryInterface $factory, EntityManager $manager, Router $router, $tokenStorage, $container)
    {
        $this->pool = $pool;
        $this->factory = $factory;
        $this->em = $manager;
        $this->router = $router;
        $this->container = $container;
        $this->tokenStorage = $tokenStorage;
        $this->matcher = new UrlMatcher($router->getRouteCollection(), new RequestContext('/'));
    }

    /**
     * createSidebarMenu перекрывает стандартное меню сонаты.
     *
     * @return MenuItem|ItemInterface $menu левое меню
     */
    public function createSidebarMenu()
    {
        $menu = $this->factory->createItem('sidebar');
        
        $requests = $this->container->get('request_stack');
        $this->sonataAdmin = $requests->getCurrentRequest()->get('_sonata_admin');
        
        //добавляем меню на основе дерева
        $cmfScript = $this->em->getRepository(CmfScript::class);
        
        $token = $this->tokenStorage->getToken();

        if ($token && $user = $token->getUser()) {
            if (is_object($user) && $user->getUserId()) {
                $tree = $cmfScript->getTreeAndCheckAccess($user->getRGHash(), 1, 1, 0, array('url'));
                $this->addAdminItems($menu, $tree);
            }
        }
        
        return $menu;
    }
    
    /**
     * createClientMenu перекрывает стандартное меню сонаты.
     *
     * @param array $options опции
     * @return MenuItem|ItemInterface $menu
     */
    public function createClientMenu(array $options)
    {
        $menu_types = [
            'top' => 76,
            'bottom' => 80,
            'cabinet' => 143,
            'cabinet_top' => 167
        ];
        $menu = $this->factory->createItem('client_'.$options['menu_type']);
        $cmfScript = $this->em->getRepository(CmfScript::class);
        
        $token = $this->tokenStorage->getToken();

        if ($token && $user = $token->getUser()) {
            if (!is_object($user) || !$user->getUserId()) {
                $user = $this->em->getRepository(User::class)->find(1);
            }
        } else {
            $user = $this->em->getRepository(User::class)->find(1);
        }
        
        $tree = $cmfScript->getTreeAndCheckAccess($user->getRGHash(), $menu_types[$options['menu_type']], 2, 0, array('url', 'realcatname', 'previewRaw'));
        $this->addItems($menu, $tree);
        return $menu;
    }

    /**
     * addItems рекурсивно добавляет узлы из дерева в меню.
     *
     * @param MenuItem $menu левое меню
     * @param array $source массив содерщащий узлы дерева
     */
    public function addItems($menu, $source)
    {
        if (isset($source) && is_array($source)) {
            foreach ($source as $j) {
                $route = '';
                
                if ($j['url']) {
                    $parameters = $this->matcher->match($j['url']);

                    if (isset($parameters['_route'])) {
                        $route = $parameters['_route'];
                    }

                    unset($parameters['_controller']);
                    unset($parameters['_route']);

                    $item = $menu->addChild($j['name'], array('uri' => $j['url'], 'route' => $route, 'routeParameters' => $parameters));
                    if(isset($j['previewRaw'])) {
                        $item->setExtras(array('icon' => $j['previewRaw']));
                    }
                    
                    if (isset($parameters['_sonata_admin']) && $this->sonataAdmin && ($parameters['_sonata_admin'] == $this->sonataAdmin)) {
                        $item->setCurrent(true);
                    }
                } elseif ($j['realcatname']) {
                    $parameters = $this->matcher->match('/'.$j['realcatname']);

                    if (isset($parameters['_route'])) {
                        $route = $parameters['_route'];
                    }

                    unset($parameters['_controller']);
                    unset($parameters['_route']);
                    $item = $menu->addChild($j['name'], array('uri' => '/'.$j['realcatname'], 'route' => $route, 'routeParameters' => $parameters));
                    if(isset($j['previewRaw'])) {
                        $item->setExtras(array('icon' => $j['previewRaw']));
                    }
                }
                
                if (isset($j['sub_items']) && is_array($j['sub_items'])) {
                    $this->addItems($menu[$j['name']], $j['sub_items']);
                }
            }
        }
    }
    
    /**
     * addAdminItems рекурсивно добавляет узлы из дерева в меню.
     *
     * @param MenuItem $menu левое меню
     * @param array $source массив содерщащий узлы дерева
     */
    public function addAdminItems($menu, $source)
    {
        if (isset($source) && is_array($source)) {
            foreach ($source as $j) {
                $route = '';

                if ($j['url']) {
                    $parameters = $this->matcher->match($j['url']);
                    
                    if (isset($parameters['_route'])) {
                        $route = $parameters['_route'];
                    }
                }
                
                $menu->addChild($j['name'], array('uri' => $j['url'], 'route' => $route));
                
                if (isset($j['sub_items']) && is_array($j['sub_items'])) {
                    $this->addItems($menu[$j['name']], $j['sub_items']);
                }
            }
        }
    }
}
