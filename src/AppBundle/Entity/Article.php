<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Application\Sonata\MediaBundle\Entity\Gallery;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\ArticleRepository")
 *
 * Статьи
 */
class Article extends AbstractEntity
{
    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="articles")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true, onDelete="SET NULL"))
     */
    private $user;
    
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"name"}, updatable=false, style="lower")
     * @ORM\Column(name="link", type="string", length=255, nullable=true)
     */
    private $link;

    /**
     * @var \DateTime $cdate Дата размещения
     *
     * @ORM\Column(name="cdate", type="datetime", nullable=true)
     */
    private $cdate;

    /**
     * @var string
     *
     * @ORM\Column(name="preview_type", type="text", nullable=true)
     */
    private $previewType;

    /**
     * @var string
     *
     * @ORM\Column(name="preview_raw", type="text", nullable=true)
     */
    private $previewRaw;

    /**
     * @var string
     *
     * @ORM\Column(name="preview_formatted", type="text", nullable=true)
     */
    private $previewFormatted;

    /**
     * @var string
     *
     * @ORM\Column(name="text_type", type="text", nullable=true)
     */
    private $textType;

    /**
     * @var string
     *
     * @ORM\Column(name="text_raw", type="text", nullable=true)
     */
    private $textRaw;

    /**
     * @var string
     *
     * @ORM\Column(name="text_formatted", type="text", nullable=true)
     */
    private $textFormatted;

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
     * @var bool
     *
     * @ORM\Column(name="status", type="boolean", options={"default" = false})
     */
    private $status;

    /**
     * @var Gallery|null Содержит видео и картинки
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Gallery")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="gallery", referencedColumnName="id")
     * })
     */
    private $gallery;

    /**
     * @var bool
     *
     * @ORM\Column(name="on_main", type="boolean", options={"default" = false})
     */
    private $onMain;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->status = false;
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
     * Set name
     *
     * @param string $name
     *
     * @return Article
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return Article
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set previewType
     *
     * @param string $previewType
     *
     * @return Article
     */
    public function setPreviewType($previewType)
    {
        $this->previewType = $previewType;

        return $this;
    }

    /**
     * Get previewType
     *
     * @return string
     */
    public function getPreviewType()
    {
        return $this->previewType;
    }

    /**
     * Set previewRaw
     *
     * @param string $previewRaw
     *
     * @return Article
     */
    public function setPreviewRaw($previewRaw)
    {
        $this->previewRaw = $previewRaw;

        return $this;
    }

    /**
     * Get previewRaw
     *
     * @return string
     */
    public function getPreviewRaw()
    {
        return $this->previewRaw;
    }

    /**
     * Set previewFormatted
     *
     * @param string $previewFormatted
     *
     * @return Article
     */
    public function setPreviewFormatted($previewFormatted)
    {
        $this->previewFormatted = $previewFormatted;

        return $this;
    }

    /**
     * Get previewFormatted
     *
     * @return string
     */
    public function getPreviewFormatted()
    {
        return $this->previewFormatted;
    }

    /**
     * Set textType
     *
     * @param string $textType
     *
     * @return Article
     */
    public function setTextType($textType)
    {
        $this->textType = $textType;

        return $this;
    }

    /**
     * Get textType
     *
     * @return string
     */
    public function getTextType()
    {
        return $this->textType;
    }

    /**
     * Set textRaw
     *
     * @param string $textRaw
     *
     * @return Article
     */
    public function setTextRaw($textRaw)
    {
        $this->textRaw = $textRaw;

        return $this;
    }

    /**
     * Get textRaw
     *
     * @return string
     */
    public function getTextRaw()
    {
        return $this->textRaw;
    }

    /**
     * Set textFormatted
     *
     * @param string $textFormatted
     *
     * @return Article
     */
    public function setTextFormatted($textFormatted)
    {
        $this->textFormatted = $textFormatted;

        return $this;
    }

    /**
     * Get textFormatted
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
     * @return Article
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
     * @return Article
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
     * @return Article
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
     * Set status
     *
     * @param boolean $status
     *
     * @return Article
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return Gallery
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * Set gallery
     *
     * @param Gallery $gallery
     *
     * @return Article
     */
    public function setGallery(Gallery $gallery = null)
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * Set cdate
     *
     * @param \DateTime $cdate
     *
     * @return Article
     */
    public function setCdate($cdate)
    {
        $this->cdate = $cdate;

        return $this;
    }

    /**
     * Get cdate
     *
     * @return \DateTime
     */
    public function getCdate()
    {
        return $this->cdate;
    }

    /**
     * Set link
     *
     * @param string $link
     *
     * @return Article
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set onMain
     *
     * @param boolean $onMain
     *
     * @return Article
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
}
