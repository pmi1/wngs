<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Catalogue
 *
 * @ORM\Table(name="catalogue")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\CatalogueRepository")
 * @ORM\HasLifecycleCallbacks
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 *
 * Дерево разделов сайта
 */
class Catalogue extends AbstractEntity
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
     * @var Media
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="image", referencedColumnName="id")
     * })
     */
    private $image;

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
     * @var \DateTime $deletedAt время удаления
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @ORM\OneToMany(targetEntity="Item", mappedBy="catalogue")
     */
    protected $items;

    /**
     * @var bool
     *
     * @ORM\Column(name="on_main", type="boolean", options={"default" = false})
     */
    private $onMain;

    /**
     * @var ArrayCollection|ItemSelection[]
     *
     * @ORM\OneToMany(targetEntity="ItemCatalogue", mappedBy="catalogue", cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC"})
     */
    private $itemCatalogues;

    /**
     * @var TextEmbed Текст с подробным содержанием сверху
     *
     * @ORM\Embedded(class="AppBundle\Entity\Embed\TextEmbed", columnPrefix="text_top_")
     */
    private $textTop;

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
        $this->textTop = new \AppBundle\Entity\Embed\TextEmbed();
    }
    
    /**
     * Get name as string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getname();
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Catalogue
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
     * @return Catalogue
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
     * @return Catalogue
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
     * @return Catalogue
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
     * @return Catalogue
     */
    public function setArticle($article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Set catname.
     *
     * @param string $catname
     *
     * @return Catalogue
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
     * @return Catalogue
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
     * @return Catalogue
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
     * @return Catalogue
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
     * Set depth.
     *
     * @param int $depth
     *
     * @return Catalogue
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
     * @return Catalogue
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
     * @return Catalogue
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
     * @return Catalogue
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
     * @return Catalogue
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
     * @return Catalogue
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
     * @return Catalogue
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
     * @return Catalogue
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
     * @return Catalogue
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
     * @return Catalogue
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
     * @return Catalogue
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
     * @return Catalogue
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
     * @return Catalogue
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
     * Set image
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $image
     *
     * @return Catalogue
     */
    public function setImage(\Application\Sonata\MediaBundle\Entity\Media $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Add item
     *
     * @param \AppBundle\Entity\Item $item
     *
     * @return Catalogue
     */
    public function addItem(\AppBundle\Entity\Item $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * Remove item
     *
     * @param \AppBundle\Entity\Item $item
     */
    public function removeItem(\AppBundle\Entity\Item $item)
    {
        $this->items->removeElement($item);
    }

    /**
     * Get items
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Set onMain
     *
     * @param boolean $onMain
     *
     * @return Catalogue
     */
    public function setOnMain($onMain)
    {
        $this->onMain = $onMain;

        return $this;
    }

    /**
     * Get onMain
     *
     * @return boolean
     */
    public function getOnMain()
    {
        return $this->onMain;
    }
    
    /**
     * @return AppBundle\Entity\Embed\TextEmbed
     */
    public function getTextTop(): \AppBundle\Entity\Embed\TextEmbed
    {
        return $this->textTop;
    }

    /**
     * @param AppBundle\Entity\Embed\TextEmbed $text
     *
     * @return mixed
     */
    public function setTextTop(\AppBundle\Entity\Embed\TextEmbed $text): self
    {
        $this->textTop = $text;

        return $this;
    }

}
