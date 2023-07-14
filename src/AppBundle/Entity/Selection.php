<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Field\ImageField;

/**
 * Selection
 *
 * @ORM\Table(name="selection")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\SelectionRepository")
 *
 * Выборки
 */
class Selection extends AbstractEntity
{
    use ImageField;
    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="selections")
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
     * @var ArrayCollection|ItemSelection[]
     *
     * @ORM\OneToMany(targetEntity="ItemSelection", mappedBy="selection", cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */
    private $itemSelections;

    /**
     * @var ArrayCollection|CmfScriptSelection[]
     *
     * @ORM\OneToMany(targetEntity="CmfScriptSelection", mappedBy="selection", cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */
    private $cmfScriptSelections;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->status = false;
        $this->itemSelections = new ArrayCollection();
    }

    /**
     * Get name as string
     
     * @return string
     */
    public function __toString()
    {
        return (string)$this->name;
    }


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Item
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
     * @param null|User $user
     *
     * @return Selection
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
     * Set textType
     *
     * @param string $textType
     *
     * @return Selection
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
     * @return Selection
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
     * @return Selection
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
     * @return Selection
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
     * @return Selection
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
     * @return Selection
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
     * @return Selection
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
     * Set link
     *
     * @param string $link
     *
     * @return Selection
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
     * Add ItemSelection
     *
     * @param ItemSelection $ItemSelection
     *
     * @return Selection
     */
    public function addItemSelection(ItemSelection $ItemSelection)
    {
        $ItemSelection->setSelection($this);
        $this->itemSelections[] = $ItemSelection;

        return $this;
    }

    /**
     * Remove ItemSelection
     *
     * @param ItemSelection $ItemSelection
     */
    public function removeItemSelection(ItemSelection $ItemSelection)
    {
        $this->itemSelections->removeElement($ItemSelection);
    }

    /**
     * Get ItemSelections
     *
     * @return ArrayCollection|ItemSelection[]
     */
    public function getItemSelections()
    {
        return $this->itemSelections;
    }

    /**
     * Get ActiveItemSelections
     *
     * @return ArrayCollection|ItemSelection[]
     */
    public function getActiveItemSelections()
    {
        $result = [];

        if ($this->itemSelections) {

            foreach ($this->itemSelections as $i) {

                if ($i->getItem()
                    && $i->getItem()->getStatus()
                    && $i->getItem()->getUser()
                    && $i->getItem()->getUser()->getDesigner()
                    && $i->getItem()->getUser()->getActiveCatalogue()) {

                    $result[] = $i;
                }
            }
        }

        return new ArrayCollection($result);
    }

    /**
     * Add cmfScriptSelection
     *
     * @param \AppBundle\Entity\CmfScriptSelection $cmfScriptSelection
     *
     * @return Selection
     */
    public function addCmfScriptSelection(\AppBundle\Entity\CmfScriptSelection $cmfScriptSelection)
    {
        $cmfScriptSelection->setSelection($this);
        $this->cmfScriptSelections[] = $cmfScriptSelection;

        return $this;
    }

    /**
     * Remove cmfScriptSelection
     *
     * @param \AppBundle\Entity\CmfScriptSelection $cmfScriptSelection
     */
    public function removeCmfScriptSelection(\AppBundle\Entity\CmfScriptSelection $cmfScriptSelection)
    {
        $this->cmfScriptSelections->removeElement($cmfScriptSelection);
    }

    /**
     * Get cmfScriptSelections
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCmfScriptSelections()
    {
        return $this->cmfScriptSelections;
    }

    /**
     * Get Active item count
     *
     * @return Int
     */
    public function getItemCount()
    {
        $result = 0;

        foreach ($this->itemSelections as $key => $value) {

            if ($value->getItem() && $value->getItem()->getStatus()) {
                $result++;
            }
        }

        return $result;
    }
}
