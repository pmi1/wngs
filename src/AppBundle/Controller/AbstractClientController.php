<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Page;
use AppBundle\Entity\Message;
use AppBundle\Entity\CmfScript;
use AppBundle\Entity\Catalogue;
use AppBundle\Entity\UserFavorite;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Базовый контроллер клиентской части
 */
abstract class AbstractClientController extends Controller
{
    /**
     * @var string|null Псевдоним раздела в таблице cmf_script
     */
    protected $article = null;
    
    /**
     * @var int|null Идентификатор раздела в таблице cmf_script
     */
    protected $scriptId = null;
    
    /**
     * @var string|null Псевдоним главной страницы сайта в таблице cmf_script
     */
    protected $mainArticle = 'mainClientPage';
    
    /**
     * @var array Дополнение к основным хлебным крошкам.
     *
     * Хлебных крошки строятся от CMFScript, сюда можно дописать хвост
     */
    protected $additionalBreadCrumbs = [];
    
    /**
     * @var string|null userToken
     */
    protected $userToken = null;
    
    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
        $this->container->get('session')->start();
        $this->userToken = $this->container->get('session')->getId();
    }
    
    /**
     * Устанавливаем userToken
     *
     * @param string $userToken
     */
    protected function setUserToken($userToken)
    {
        $this->userToken = $userToken;
    }

    /**
     * userToken
     *
     * @return string|null
     */
    protected function getUserToken(): string
    {
        return $this->userToken;
    }
    

    /**
     * Устанавливаем пседоним раздела
     *
     * @param string $article Псевдоним раздела в таблице cmf_script
     */
    protected function setArticle($article)
    {
        $this->article = $article;
    }

    /**
     * Получаем текущий псевдоним раздела
     *
     * @return string|null
     */
    protected function getArticle()
    {
        return $this->article;
    }
    
    /**
     * Устанавливаем идентификатор раздела
     *
     * @param int $scriptId Идентификатор раздела в таблице cmf_script
     */
    protected function setScriptId($scriptId)
    {
        $this->scriptId = $scriptId;
    }

    /**
     * Получаем текущий псевдоним раздела
     *
     * @return int|null
     */
    protected function getScriptId()
    {
        return $this->scriptId;
    }

    /**
     * Получаем запись из cmf_script текущего раздела
     *
     * @return CmfScript
     */
    protected function getPageInfo()
    {
        $info = null;
        
        $scriptRepo = $this->getDoctrine()->getRepository(CmfScript::class);
        if ($article = $this->getArticle()) {
            $info = $scriptRepo->findOneByArticle($article);
        } elseif ($scriptId = $this->getScriptId()) {
            $info = $scriptRepo->findOneById($scriptId);
        }
        
        unset($scriptRepo);
        return $info;
    }

    /**
     * Добавляем к параметрам шаблона дефолтные значения: мета-теги, информацию о текущей странице
     *
     * @param array $parameters Параметры, передаваемые в шаблон
     */
    protected function modifyParameters(&$parameters)
    {
        $parameters['pageInfo'] = $this->getPageInfo();
        
        $defaultMeta = [
            'metaTitle' => '',
            'metaKeywords' => '',
            'metaDescription' => '',
        ];
        
        if ($parameters['pageInfo'] instanceof CmfScript) {
            $defaultMeta['metaTitle'] = $parameters['pageInfo']->getMetaTitle();
            $defaultMeta['metaKeywords'] = $parameters['pageInfo']->getMetaKeywords();
            $defaultMeta['metaDescription'] = $parameters['pageInfo']->getMetaDescription();
            $defaultMeta['pageName'] = $parameters['pageInfo']->getName();
            
            if (!$defaultMeta['metaTitle']) {
                $defaultMeta['metaTitle'] = $parameters['pageInfo']->getName();
            }
        }
        
        $parameters['breadcrumbs'] = $this->generateBreadCrumbs();
        $parameters['top_catalogues'] = $this->getCatalogues();
        $parameters['banners'] = $this->getBanners();
        $parameters['favorite_count'] = $this->getFavorite();
        $parameters['newMessageCount'] = $this->getNewMessage();
        $parameters['userToken'] = $this->userToken;

        if (! isset($parameters['catalogues'])) {
            $parameters['catalogues'] = $this->getCatalogues(3);
        }
        
        $parameters = array_merge($defaultMeta, $parameters);
    }

    /**
     * Рубрики
     *
     * @param int $rootId Идентификатор кликини
     *
     * @return array
     */
    protected function getCatalogues($rootId = 0)
    {
        $catalogueRepo = $this->getDoctrine()->getRepository(Catalogue::class);
        $result = $catalogueRepo->getTree($rootId, 1, 1, ['t.realcatname']);
        unset($catalogueRepo);
        return $result;
    }

    /**
     * Избранное
     *
     * @return array
     */
    protected function getFavorite()
    {
        $user = $this->getUser();

        if ($user) {
            $userFavoriteRepo = $this->getDoctrine()->getRepository(UserFavorite::class);
            $count = $userFavoriteRepo->getCount($user->getId());
        } else {
            $count =0;
        }

        return $count;
    }

    /**
     * Новые сообщения
     *
     * @return array
     */
    protected function getNewMessage()
    {
        $user = $this->getUser();

        if ($user) {
            $count = $this->getDoctrine()
                ->getRepository(Message::class)
                ->getCount($user->getId());
        } else {
            $count =0;
        }

        return $count;
    }


    /**
     * Баннеры
     *
     * @return array
     */
    protected function getBanners()
    {
        $pageRepo = $this->getDoctrine()->getRepository(Page::class);
        $result = $pageRepo->findBy([
                    'bannerPlace' => 6,
                    'status' => 1
                ]);
        return $result;
    }

            
    /**
     * Генерим хлебные крошки текущей страницы на основе article (cmf_script)
     *
     * @return array
     */
    protected function generateBreadCrumbs()
    {
        $breadcrumbs = [];
        
        if ($this->article || $this->scriptId) {
            $scriptManager = $this->container->get('app.script_manager');
            
            $scriptRepo = $this->getDoctrine()->getRepository(CmfScript::class);
            $scripts = $scriptRepo->generateBreadCrumbs($this->mainArticle, $this->article, $this->scriptId);

            foreach ($scripts as $script) {
                $url = $scriptManager->generateUrl($script);
                
                $breadcrumbs[] = [
                    'name' => $script->getName(),
                    'url' => $url,
                ];
            }
            
            foreach ($this->additionalBreadCrumbs as $breadcrumb) {
                $breadcrumbs[] = $breadcrumb;
            }
        }
        
        return $breadcrumbs;
    }
    
    /**
     * Добавить хлебную крошку
     *
     * @param string|null $url урл крошки
     * @param string $name название крошки
     */
    protected function addBreadCrumb($url = null, $name)
    {
        $this->additionalBreadCrumbs[] = [
            'url' => $url,
            'name' => $name,
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    protected function render($view, array $parameters = array(), Response $response = null)
    {
        $this->modifyParameters($parameters);
        
        return parent::render($view, $parameters, $response);
    }
}
