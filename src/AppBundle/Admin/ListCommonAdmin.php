<?php

namespace AppBundle\Admin;

use AppBundle\Entity\AbstractEntity;
use AppBundle\Entity\CmfConfigure;
use AppBundle\Exception\DoctrineFilterNotFoundException;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\DoctrineORMAdminBundle\Model\ModelManager;
use Symfony\Component\HttpFoundation\Response;

/**
 * Дефолтный админ-файл для списковых сущностей
 */
class ListCommonAdmin extends AbstractAdmin
{
    /**
     * Должно быть задано в контроллере наследнике, если в админке нужно отображать ссылку на просмотр из поля link
     *
     * @var string $clientPageRoute Название маршрута для карточки на клиентской части.
     */
    protected $clientPageRoute = null;
    protected $customTemlates = [
        'gallery' => 'admin/list_fields/list_image.html.twig',
        'link' => 'admin/list_fields/show_site.html.twig',
    ];

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('configure', 'configure')
                   ->add('clone', $this->getRouterIdParameter().'/clone');
    }

    /**
     * {@inheritdoc}
     */
    public function configureActionButtons($action, $object = null)
    {
        $list = parent::configureActionButtons($action, $object);
        
        if ($action === 'list') {
            $list['configure'] = array('template' => 'admin/buttons/configure_field_list.html.twig');
        }

        return $list;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $configure = $this->modelManager
            ->getEntityManager(CmfConfigure::class)
            ->getRepository(CmfConfigure::class);
        $fields = $configure->getFieldsToDisplay($this->getClassnameLabel());
        
        foreach ($fields as $v) {
            if ($v === 'cmfScript') {
                $datagridMapper->add($v, null, array('admin_code' => 'admin.cmfscript'));
            } else {
                $datagridMapper->add($v);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $userId = 1;
        $configure = $this->modelManager
            ->getEntityManager(CmfConfigure::class)
            ->getRepository(CmfConfigure::class);
        
        $fields = $configure->getConfigureFields($userId, $this->getClassnameLabel());
        $editableFields = $this->getEditableFieldsInList();
        
        foreach ($fields as $v) {
            if ($v['isVisuality']) {
                if (isset($this->customTemlates[$v['fieldName']])) {
                    $listMapper->add($v['fieldName'], null, [
                        'template' => $this->customTemlates[$v['fieldName']]
                    ]);
                } else {
                    if (in_array($v['fieldName'], $editableFields)) {
                        $listMapper->add($v['fieldName'], null, [
                            'editable' => true
                        ]);
                    } elseif ($v['fieldName'] === 'cmfScript') {
                        $listMapper->add($v['fieldName'], null, array('admin_code' => 'admin.cmfscript', 'identifier' => true, 'route' => array('name' => 'edit', 'parameters' => array())));
                    } else {
                        $listMapper->addIdentifier($v['fieldName']);
                    }
                }
            }
        }
        $listMapper->add('_action', null, [
                'actions' => [
                    'clone' => [
                        'template' => 'admin/buttons/list__action_clone.html.twig'
                    ]
                ]
            ]);
        // Отключаем фильтр SoftDeleteable для супер администраторов
        if ($this->isGranted('ROLE_SUPER_ADMIN')) {
            $this->disableDoctrineFilter('softdeleteable');
        }

        //return $listMapper;
    }
    
    /**
     * Получаем список полей, которые можно редактировать в списке
     *
     * @return array
     */
    protected function getEditableFieldsInList()
    {
        return [
            'status',
        ];
    }

    /**
     * Метод позволяет отключить фильтр доктрины по его имени
     *
     * @param string $name Название фильтра
     * @return self
     */
    private function disableDoctrineFilter(string $name): self
    {
        $modelManager = $this->getModelManager();

        if (!$modelManager instanceof ModelManager) {
            throw $this->createModelManagerException();
        }

        $filters = $modelManager->getEntityManager($this->getClass())->getFilters();

        if (!array_key_exists($name, $filters->getEnabledFilters())) {
            throw new DoctrineFilterNotFoundException($name);
        }

        $filters->disable($name);

        return $this;
    }

    /**
     * Исключение
     *
     * @return \InvalidArgumentException
     */
    private function createModelManagerException(): \InvalidArgumentException
    {
        return new \InvalidArgumentException(
            'Переменная не является объектом ModelManager',
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }
    
    /**
     * Convert to translit
     *
     * @param string $cyr_str
     *
     * @return string
     */
    public function translit($cyrStr)
    {
        $translitMap = array(
            "А" => "A", "Б" => "B", "В" => "V", "Г" => "G",
            "Д" => "D", "Е" => "E", "Ё" => "YO", "Ж" => "ZH", "З" => "Z", "И" => "I",
            "Й" => "Y", "К" => "K", "Л" => "L", "М" => "M", "Н" => "N",
            "О" => "O", "П" => "P", "Р" => "R", "С" => "S", "Т" => "T",
            "У" => "U", "Ф" => "F", "Х" => "H", "Ц" => "TS", "Ч" => "CH",
            "Ш" => "SH", "Щ" => "SCH", "Ъ" => "'", "Ы" => "YI", "Ь" => "",
            "Э" => "E", "Ю" => "YU", "Я" => "YA", "а" => "a", "б" => "b",
            "в" => "v", "г" => "g", "д" => "d", "е" => "e", "ё" => "yo", "ж" => "zh",
            "з" => "z", "и" => "i", "й" => "y", "к" => "k", "л" => "l",
            "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r",
            "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "h",
            "ц" => "ts", "ч" => "ch", "ш" => "sh", "щ" => "sch", "ъ" => "'",
            "ы" => "yi", "ь" => "", "э" => "e", "ю" => "yu", "я" => "ya", " " => '-'
            );
        
        $string = strtr($cyrStr, $translitMap);
        
        $string = preg_replace("~[^0-9a-zA-Z\']+~", '-', $string);
        
        return $string;
    }
    
    /**
     * Convert name to url
     *
     * @param string $cyr_str
     *
     * @return string
     */
    public function nameToLink($cyrStr)
    {
        return $this->translit($cyrStr);
    }
    
    /**
     * Собираем url страницы на клиентской части.
     *
     * @param AbstractEntity $object модель, для каждой страницы в админке своя
     *
     * @return string
     */
    public function getClientUrl(AbstractEntity $object)
    {
        $url = null;

        if ($this->clientPageRoute) {
            $container = $this->getConfigurationPool()->getContainer();
            $slug = trim($object->getLink(), '/');
            
            if ($slug) {
                $url = $container->get('router')->generate($this->clientPageRoute, array('slug' => $slug));
            }
        }

        return $url;
    }
}
