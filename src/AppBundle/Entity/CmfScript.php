<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CmfScript.
 *
 * @ORM\Table(name="cmf_script")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\CmfScriptRepository")
 * @ORM\HasLifecycleCallbacks
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 *
 * Дерево разделов сайта
 */
class CmfScript extends AbstractEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="meta_title", type="string", length=255, nullable=true)
     */
    private $metaTitle;
    
    /**
     * @var string
     *
     * @ORM\Column(name="meta_description", type="text", nullable=true)
     */
    private $metaDescription;
    
    /**
     * @var string
     *
     * @ORM\Column(name="meta_keywords", type="text", nullable=true)
     */
    private $metaKeywords;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="parent_id", type="integer")
     */
    private $parentId;

    /**
     * @var int Уровень вложенности раздела
     *
     * @ORM\Column(type="integer")
     */
    private $depth;

    /**
     * @var bool
     *
     * @ORM\Column(name="status", type="boolean", nullable=true, options={"default" = false})
     */
    private $status;

    /**
     * @var bool Статус раздела с учетом всех предков. Если родитель отключен, то и раздел тоже будет отключен
     *
     * @ORM\Column(name="real_status", type="boolean", nullable=true, options={"default" = false})
     */
    private $realStatus;

    /**
     * @var string Артикул, вместо ID (синоним), человекоподобный идентификатор раздела
     *
     * @ORM\Column(name="article", type="string", length=255, nullable=true)
     */
    private $article;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="catname", type="string", length=255, nullable=true)
     */
    private $catname;

    /**
     * @var string Путь к разделу с учетом всех предков
     *
     * @ORM\Column(name="realcatname", type="string", length=255, nullable=true)
     */
    private $realcatname;

    /**
     * @var string Тип визуального редактора для поля с кратким описанием
     *
     * @ORM\Column(name="preview_type", type="text", nullable=true)
     */
    private $previewType;

    /**
     * @var string текст краткого описания в исходном формате
     *
     * @ORM\Column(name="preview_raw", type="text", nullable=true)
     */
    private $previewRaw;

    /**
     * @var string текст краткого описания, отформатированный для клиентской части
     *
     * @ORM\Column(name="preview_formatted", type="text", nullable=true)
     */
    private $previewFormatted;

    /**
     * @var string Тип визуального редактора для поля с подробным описанием
     *
     * @ORM\Column(name="text_type", type="text", nullable=true)
     */
    private $textType;

    /**
     * @var string текст подробного описания в исходном формате
     *
     * @ORM\Column(name="text_raw", type="text", nullable=true)
     */
    private $textRaw;

    /**
     * @var string текст подробного описания, отформатированный для клиентской части
     *
     * @ORM\Column(name="text_formatted", type="text", nullable=true)
     */
    private $textFormatted;

    /**
     * @var int сортировка
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ordering;

    /**
     * @var int Левая граница в nested tree
     *
     * @ORM\Column(type="integer")
     */
    private $leftMargin;

    /**
     * @var int Правая граница в nested tree
     *
     * @ORM\Column(type="integer")
     */
    private $rightMargin;

    /**
     * @var bool Раздел последний в дереве?
     *
     * @ORM\Column(name="lastnode", type="boolean", nullable=true, options={"default" = false})
     */
    private $lastnode;

    /**
     * @var string Название Entity
     *
     * @ORM\Column(name="modelname", type="string", length=255, nullable=true, options={"default" = false})
     */
    private $modelname;

    /**
     * @var bool Является группообразующим злом?
     *
     * @ORM\Column(name="is_group_node", type="boolean", nullable=true, options={"default" = false})
     */
    private $isGroupNode;

    /**
     * @var bool Открывать в новом окне?
     *
     * @ORM\Column(name="is_new_win", type="boolean", nullable=true, options={"default" = false})
     */
    private $isNewWin;

    /**
     * @var bool Не учитывать при составлении пути?
     *
     * @ORM\Column(name="is_exclude_path", type="boolean", nullable=true, options={"default" = false})
     */
    private $isExcludePath;

    /**
     * @var bool Учитывать в поиске?
     *
     * @ORM\Column(name="is_search", type="boolean", nullable=true, options={"default" = false})
     */
    private $isSearch;

    /**
     * @var ArrayCollection|CmfScriptSelection[]
     *
     * @ORM\OneToMany(targetEntity="CmfScriptSelection", mappedBy="cmfScript", cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */
    private $cmfScriptSelections;

    /**
     * @var ArrayCollection|Role[]
     *
     * @ORM\ManyToMany(targetEntity="Role", mappedBy="cmfScripts")
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $roles;
    
    /**
     * @var \DateTime $deletedAt время удаления
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->parentId = 0;
        $this->depth = 1;
        $this->status = false;
        $this->realStatus = false;
        $this->ordering = 1;
        $this->leftMargin = 1;
        $this->rightMargin = 1;
        $this->lastnode = true;
        $this->isGroupNode = false;
        $this->isNewWin = false;
        $this->isExcludePath = false;
        $this->isSearch = false;
        $this->roles = new ArrayCollection();
    }
    
    /**
     * Get name as string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name ? $this->name : '';
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return CmfScript
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set parentId.
     *
     * @param int $parentId
     *
     * @return CmfScript
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * Get parentId.
     *
     * @return int
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Set status.
     *
     * @param bool $status
     *
     * @return CmfScript
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return bool
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set realStatus.
     *
     * @param bool $realStatus
     *
     * @return CmfScript
     */
    public function setRealStatus($realStatus)
    {
        $this->realStatus = $realStatus;

        return $this;
    }

    /**
     * Get realStatus.
     *
     * @return bool
     */
    public function getRealStatus()
    {
        return $this->realStatus;
    }

    /**
     * Set article.
     *
     * @param string $article
     *
     * @return CmfScript
     */
    public function setArticle($article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article.
     *
     * @return string
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set url.
     *
     * @param string $url
     *
     * @return CmfScript
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set catname.
     *
     * @param string $catname
     *
     * @return CmfScript
     */
    public function setCatname($catname)
    {
        $this->catname = $catname;

        return $this;
    }

    /**
     * Get catname.
     *
     * @return string
     */
    public function getCatname()
    {
        return $this->catname;
    }

    /**
     * Set realcatname.
     *
     * @param string $realcatname
     *
     * @return CmfScript
     */
    public function setRealcatname($realcatname)
    {
        $this->realcatname = $realcatname;

        return $this;
    }

    /**
     * Get realcatname.
     *
     * @return string
     */
    public function getRealcatname()
    {
        return $this->realcatname;
    }

    /**
     * Set ordering.
     *
     * @param int $ordering
     *
     * @return CmfScript
     */
    public function setOrdering($ordering)
    {
        $this->ordering = $ordering;

        return $this;
    }

    /**
     * Get ordering.
     *
     * @return int
     */
    public function getOrdering()
    {
        return $this->ordering;
    }

    /**
     * Set lastnode.
     *
     * @param bool $lastnode
     *
     * @return CmfScript
     */
    public function setLastnode($lastnode)
    {
        $this->lastnode = $lastnode;

        return $this;
    }

    /**
     * Get lastnode.
     *
     * @return bool
     */
    public function getLastnode()
    {
        return $this->lastnode;
    }

    /**
     * Set modelname.
     *
     * @param string $modelname
     *
     * @return CmfScript
     */
    public function setModelname($modelname)
    {
        $this->modelname = $modelname;

        return $this;
    }

    /**
     * Get modelname.
     *
     * @return string
     */
    public function getModelname()
    {
        return $this->modelname;
    }

    /**
     * Set isGroupNode.
     *
     * @param bool $isGroupNode
     *
     * @return CmfScript
     */
    public function setIsGroupNode($isGroupNode)
    {
        $this->isGroupNode = $isGroupNode;

        return $this;
    }

    /**
     * Get isGroupNode.
     *
     * @return bool
     */
    public function getIsGroupNode()
    {
        return $this->isGroupNode;
    }

    /**
     * Set isNewWin.
     *
     * @param bool $isNewWin
     *
     * @return CmfScript
     */
    public function setIsNewWin($isNewWin)
    {
        $this->isNewWin = $isNewWin;

        return $this;
    }

    /**
     * Get isNewWin.
     *
     * @return bool
     */
    public function getIsNewWin()
    {
        return $this->isNewWin;
    }

    /**
     * Set isExcludePath.
     *
     * @param bool $isExcludePath
     *
     * @return CmfScript
     */
    public function setIsExcludePath($isExcludePath)
    {
        $this->isExcludePath = $isExcludePath;

        return $this;
    }

    /**
     * Get isExcludePath.
     *
     * @return bool
     */
    public function getIsExcludePath()
    {
        return $this->isExcludePath;
    }

    /**
     * Set isSearch.
     *
     * @param bool $isSearch
     *
     * @return CmfScript
     */
    public function setIsSearch($isSearch)
    {
        $this->isSearch = $isSearch;

        return $this;
    }

    /**
     * Get isSearch.
     *
     * @return bool
     */
    public function getIsSearch()
    {
        return $this->isSearch;
    }

    /**
     * @param LifecycleEventArgs $args Объект, хранящий текущую Entity и Entity Manager
     *
     * @ORM\PostPersist
     */
    public function rebuildsOnPostPersist($args)
    {
        $em = $args->getEntityManager();
        $entity = $args->getEntity();
        $repo = $em->getRepository(get_class($this));

        $repo->setDepthForId($entity->getId());
        $repo->RebuildTreeOrdering();
        $repo->rebuildRealCatnameForId($entity->getId());
        $repo->rebuildRealStatusForId($entity->getId());
        $repo->initLastnodeForId($entity->getId());
    }

    /**
     * @param LifecycleEventArgs $args Объект, хранящий текущую Entity и Entity Manager
     *
     * @ORM\PostUpdate
     */
    public function rebuildsOnPostUpdate($args)
    {
        $em = $args->getEntityManager();
        $entity = $args->getEntity();
        $repo = $em->getRepository(get_class($this));

        $repo->RebuildTreeOrdering();
        $repo->rebuildRealCatnameForId($entity->getId());
        $repo->rebuildRealStatusForId($entity->getId());
    }

    /**
     * @param LifecycleEventArgs $args Объект, хранящий текущую Entity и Entity Manager
     *
     * @ORM\PreRemove
     */
    public function rebuildsOnPreRemove($args)
    {
        $em = $args->getEntityManager();
        $entity = $args->getEntity();
        $repo = $em->getRepository(get_class($this));

        $repo->recheckLastnodeForId($entity->getId());
        $repo->deleteSubTree($entity->getId());
    }

    /**
     * Add role.
     *
     * @param Role $role
     *
     * @return CmfScript
     */
    public function addRole(Role $role)
    {
        $this->roles[$role->getId()] = $role;
        $role->addCmfScript($this);
        
        return $this;
    }

    /**
     * Remove role.
     *
     * @param Role $role
     *
     * @return CmfScript
     */
    public function removeRole(Role $role)
    {
        $this->roles->removeElement($role);
        $role->removeCmfScript($this);
        
        return $this;
    }

    /**
     * Get roles.
     *
     * @return ArrayCollection
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set depth.
     *
     * @param int $depth
     *
     * @return CmfScript
     */
    public function setDepth($depth)
    {
        $this->depth = $depth;

        return $this;
    }

    /**
     * Get depth.
     *
     * @return int
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * Set leftMargin.
     *
     * @param int $leftMargin
     *
     * @return CmfScript
     */
    public function setLeftMargin($leftMargin)
    {
        $this->leftMargin = $leftMargin;

        return $this;
    }

    /**
     * Get leftMargin.
     *
     * @return int
     */
    public function getLeftMargin()
    {
        return $this->leftMargin;
    }

    /**
     * Set rightMargin.
     *
     * @param int $rightMargin
     *
     * @return CmfScript
     */
    public function setRightMargin($rightMargin)
    {
        $this->rightMargin = $rightMargin;

        return $this;
    }

    /**
     * Get rightMargin.
     *
     * @return int
     */
    public function getRightMargin()
    {
        return $this->rightMargin;
    }

    /**
     * Set previewRaw.
     *
     * @param string $previewRaw
     *
     * @return CmfScript
     */
    public function setPreviewRaw($previewRaw)
    {
        $this->previewRaw = $previewRaw;

        return $this;
    }

    /**
     * Get previewRaw.
     *
     * @return string
     */
    public function getPreviewRaw()
    {
        return $this->previewRaw;
    }

    /**
     * Set previewFormatted.
     *
     * @param string $previewFormatted
     *
     * @return CmfScript
     */
    public function setPreviewFormatted($previewFormatted)
    {
        $this->previewFormatted = $previewFormatted;

        return $this;
    }

    /**
     * Get previewFormatted.
     *
     * @return string
     */
    public function getPreviewFormatted()
    {
        return $this->previewFormatted;
    }

    /**
     * Set previewType.
     *
     * @param string $previewType
     *
     * @return CmfScript
     */
    public function setPreviewType($previewType)
    {
        $this->previewType = $previewType;

        return $this;
    }

    /**
     * Get previewType.
     *
     * @return string
     */
    public function getPreviewType()
    {
        return $this->previewType;
    }

    /**
     * Set textType.
     *
     * @param string $textType
     *
     * @return CmfScript
     */
    public function setTextType($textType)
    {
        $this->textType = $textType;

        return $this;
    }

    /**
     * Get textType.
     *
     * @return string
     */
    public function getTextType()
    {
        return $this->textType;
    }

    /**
     * Set textRaw.
     *
     * @param string $textRaw
     *
     * @return CmfScript
     */
    public function setTextRaw($textRaw)
    {
        $this->textRaw = $textRaw;

        return $this;
    }

    /**
     * Get textRaw.
     *
     * @return string
     */
    public function getTextRaw()
    {
        return $this->textRaw;
    }

    /**
     * Set textFormatted.
     *
     * @param string $textFormatted
     *
     * @return CmfScript
     */
    public function setTextFormatted($textFormatted)
    {
        $this->textFormatted = $textFormatted;

        return $this;
    }

    /**
     * Get textFormatted.
     *
     * @return string
     */
    public function getTextFormatted()
    {
        return $this->textFormatted;
    }

    /**
     * Set metaTitle
     *
     * @param string $metaTitle
     *
     * @return CmfScript
     */
    public function setMetaTitle($metaTitle)
    {
        $this->metaTitle = $metaTitle;

        return $this;
    }

    /**
     * Get metaTitle
     *
     * @return string
     */
    public function getMetaTitle()
    {
        return $this->metaTitle;
    }

    /**
     * Set metaDescription
     *
     * @param string $metaDescription
     *
     * @return CmfScript
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    /**
     * Get metaDescription
     *
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * Set metaKeywords
     *
     * @param string $metaKeywords
     *
     * @return CmfScript
     */
    public function setMetaKeywords($metaKeywords)
    {
        $this->metaKeywords = $metaKeywords;

        return $this;
    }

    /**
     * Get metaKeywords
     *
     * @return string
     */
    public function getMetaKeywords()
    {
        return $this->metaKeywords;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     *
     * @return CmfScript
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Add cmfScriptSelection
     *
     * @param CmfScriptSelection $cmfScriptSelection
     *
     * @return CmfScript
     */
    public function addCmfScriptSelection(CmfScriptSelection $cmfScriptSelection)
    {
        $cmfScriptSelection->setCmfScript($this);
        $this->cmfScriptSelections[] = $cmfScriptSelection;

        return $this;
    }

    /**
     * Remove cmfScriptSelection
     *
     * @param CmfScriptSelection $cmfScriptSelection
     */
    public function removeCmfScriptSelection(CmfScriptSelection $cmfScriptSelection)
    {
        $this->cmfScriptSelections->removeElement($cmfScriptSelection);
    }

    /**
     * Get cmfScriptSelections
     *
     * @return Collection|CmfScriptSelection[]
     */
    public function getCmfScriptSelections()
    {
        return $this->cmfScriptSelections;
    }

    /**
     * Get ActiveCmfScriptSelections
     *
     * @return ArrayCollection|CmfScriptSelection[]
     */
    public function getActiveCmfScriptSelections()
    {
        $result = [];

        if ($this->cmfScriptSelections) {

            foreach ($this->cmfScriptSelections as $i) {

                if ($i->getSelection()
                    && $i->getSelection()->getStatus()
                    && (($i->getSelection()->getUser()
                    && $i->getSelection()->getUser()->getDesigner()
                    && $i->getSelection()->getUser()->getActiveCatalogue()) || !$i->getSelection()->getUser())) {

                    $result[] = $i;
                }
            }
        }

        return new ArrayCollection($result);
    }


}
