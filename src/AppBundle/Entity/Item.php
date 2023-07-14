<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Application\Sonata\MediaBundle\Entity\Gallery;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Item
 *
 * @ORM\Table(name="item")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\ItemRepository")
 * @ORM\EntityListeners({"AppBundle\EventListener\ItemListener"})
 *
 * Товары
 */
class Item extends AbstractEntity
{
    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="items")
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
     * @var bool
     *
     * @ORM\Column(name="can_ask_discount", type="boolean", options={"default" = true})
     */
    private $canAskDiscount;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_availabile", type="boolean", options={"default" = false})
     */
    private $isAvailabile;

    /**
     * @var TextEmbed Доставка
     *
     * @ORM\Column(name="delivery", type="text", nullable=true)
     */
    private $delivery;

    /**
     * @var TextEmbed Оплата
     *
     * @ORM\Column(name="payment", type="text", nullable=true)
     */
    private $payment;

    /**
     * @var TextEmbed Условия
     *
     * @ORM\Column(name="`condition`", type="text", nullable=true)
     */
    private $condition;

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
     * @var string
     *
     * @ORM\Column(name="price", type="integer", length=11, nullable=true)
     * @Assert\GreaterThanOrEqual(value="0", message="Значение цены не может быть меньше 0")
     */
    private $price;

    /**
     * @var smallint Значение скидки в процентах
     *
     * @ORM\Column(name="discount", type="smallint", nullable=true)
     * @Assert\LessThanOrEqual(value="99", message="Значение скидки не может превышать 99%")
     * @Assert\GreaterThanOrEqual(value="0", message="Значение скидки не может быть меньше 0%")
     */
    private $discount;

    /**
     * @var string
     *
     * @ORM\Column(name="popularity", type="integer", length=11, nullable=true)
     * @Assert\GreaterThanOrEqual(value="0", message="Значение цены не может быть меньше 0")
     */
    private $popularity;

    /**
     * @var ArrayCollection|ItemAttribute[]
     *
     * @ORM\OneToMany(targetEntity="ItemAttribute", mappedBy="item", cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */
    private $itemAttributes;

    /**
     * @var ArrayCollection|ItemSelection[]
     *
     * @ORM\OneToMany(targetEntity="ItemSelection", mappedBy="item", cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */
    private $itemSelections;

    /**
     * @var Catalogue
     *
     * @ORM\ManyToOne(targetEntity="Catalogue", inversedBy="items")
     * @ORM\JoinColumn(name="catalogue_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $catalogue;

    /**
     * @var ArrayCollection|UserFavorite[]
     *
     * @ORM\OneToMany(targetEntity="UserFavorite", mappedBy="item", cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */

    protected $favorites;


    /**
     * @var ArrayCollection|FormAnswer[]
     *
     * @ORM\OneToMany(targetEntity="FormAnswer", mappedBy="item", cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */

    protected $requests;

    /**
     * @var ArrayCollection|ItemColor[]
     *
     * @ORM\OneToMany(targetEntity="ItemColor", mappedBy="item", cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */

    protected $colors;

    /**
     * @var ArrayCollection|ItemCatalogue[]
     *
     * @ORM\OneToMany(targetEntity="ItemCatalogue", mappedBy="item", cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */

    protected $catalogues;

    protected $isPromo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->status = false;
        $this->isPromo = false;
        $this->itemAttributes = new ArrayCollection();
        $this->itemSelections = new ArrayCollection();
        $this->favorites = new ArrayCollection();
        $this->requests = new ArrayCollection();
        $this->catalogues = new ArrayCollection();
        $this->colors = new ArrayCollection();
    }

    /**
     * Get name as string
     
     * @return string
     */
    public function __toString()
    {
        return $this->name;
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
     * @param User $user
     *
     * @return Item
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
     * @return Item
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
     * @return Item
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
     * @return Item
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
     * @return Item
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
     * @return Item
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
     * @return Item
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
     * @return Item
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
     * @return Item
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
     * @return Item
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
     * @return Item
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
     * Set price
     *
     * @param integer $price
     *
     * @return Item
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set discount
     *
     * @param integer $discount
     *
     * @return Item
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * Get discount
     *
     * @return integer
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Add itemAttribute
     *
     * @param ItemAttribute $itemAttribute
     *
     * @return Item
     */
    public function addItemAttribute(ItemAttribute $itemAttribute)
    {
        $itemAttribute->setItem($this);
        $this->itemAttributes[] = $itemAttribute;

        return $this;
    }

    /**
     * Remove itemAttribute
     *
     * @param ItemAttribute $itemAttribute
     */
    public function removeItemAttribute(ItemAttribute $itemAttribute)
    {
        $this->itemAttributes->removeElement($itemAttribute);
    }

    /**
     * Get itemAttributes
     *
     * @return ArrayCollection|ItemAttribute[]
     */
    public function getItemAttributes()
    {
        return $this->itemAttributes;
    }

    /**
     * Add itemSelection
     *
     * @param ItemSelection $itemSelection
     *
     * @return Item
     */
    public function addItemSelection(\AppBundle\Entity\ItemSelection $itemSelection)
    {
        $itemSelection->setItem($this);
        $this->itemSelections[] = $itemSelection;

        return $this;
    }

    /**
     * Remove itemSelection
     *
     * @param ItemSelection $itemSelection
     */
    public function removeItemSelection(\AppBundle\Entity\ItemSelection $itemSelection)
    {
        $this->itemSelections->removeElement($itemSelection);
    }

    /**
     * Get itemSelections
     *
     * @return Collection|ItemSelection[]
     */
    public function getItemSelections()
    {
        return $this->itemSelections;
    }

    /**
     * Set catalogue
     *
     * @param Catalogue $catalogue
     *
     * @return Item
     */
    public function setCatalogue(Catalogue $catalogue = null)
    {
        $this->catalogue = $catalogue;

        return $this;
    }

    /**
     * Get catalogue
     *
     * @return \AppBundle\Entity\Catalogue
     */
    public function getCatalogue()
    {
        return $this->catalogue;
    }

    /**
     * Add favorite
     *
     * @param \AppBundle\Entity\UserFavorite $favorite
     *
     * @return Item
     */
    public function addFavorite(\AppBundle\Entity\UserFavorite $favorite)
    {
        $favorite->setItem($this);
        $this->favorites[] = $favorite;

        return $this;
    }

    /**
     * Remove favorite
     *
     * @param \AppBundle\Entity\UserFavorite $favorite
     */
    public function removeFavorite(\AppBundle\Entity\UserFavorite $favorite)
    {
        $this->favorites->removeElement($favorite);
    }

    /**
     * Get favorites
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFavorites()
    {
        return $this->favorites;
    }

    /**
     * Add catalogue
     *
     * @param \AppBundle\Entity\ItemCatalogue $catalogue
     *
     * @return Item
     */
    public function addCatalogue(\AppBundle\Entity\ItemCatalogue $catalogue)
    {
        $catalogue->setItem($this);
        $this->catalogues[] = $catalogue;

        return $this;
    }

    /**
     * Remove catalogue
     *
     * @param \AppBundle\Entity\ItemCatalogue $catalogue
     */
    public function removeCatalogue(\AppBundle\Entity\ItemCatalogue $catalogue)
    {
        $this->catalogues->removeElement($catalogue);
    }

    /**
     * Get catalogues
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCatalogues()
    {
        return $this->catalogues;
    }

    /**
     * Get discount
     *
     * @return integer
     */
    public function getPriceWithDiscount()
    {
        return $this->price*(100-$this->discount)/100;
    }

    /**
     * Get all catalogues
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAllCatalogues()
    {
        $result = [];
        if ($catalogue = $this->catalogue) {
            $result[$catalogue->getId()] = $catalogue;
        }

        if ($this->catalogues) {

            foreach ($this->catalogues as $i) {
                $result[$i->getCatalogue()->getId()] = $i->getCatalogue();
            }
        }

        return new ArrayCollection($result);
    }


    /**
     * Get all selections
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSelections()
    {
        $result = [];

        if ($this->itemSelections) {

            foreach ($this->itemSelections as $i) {

                if ($i->getSelection()->getStatus() && $i->getStatus()) {
                    $result[$i->getSelection()->getId()] = $i->getSelection();
                }
            }
        }

        return new ArrayCollection($result);
    }

    /**
     * Get selections
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAllSelections()
    {
        $result = [];

        if ($this->itemSelections) {

            foreach ($this->itemSelections as $i) {

                $result[$i->getSelection()->getId()] = $i->getSelection();
            }
        }

        return new ArrayCollection($result);
    }

    /**
     * Set popularity
     *
     * @param integer $popularity
     *
     * @return Item
     */
    public function setPopularity($popularity)
    {
        $this->popularity = $popularity;

        return $this;
    }

    /**
     * Get popularity
     *
     * @return integer
     */
    public function getPopularity()
    {
        return $this->popularity;
    }

    /**
     * Add request
     *
     * @param \AppBundle\Entity\FormAnswer $request
     *
     * @return Item
     */
    public function addRequest(\AppBundle\Entity\FormAnswer $request)
    {
        $this->requests[] = $request;

        return $this;
    }

    /**
     * Remove request
     *
     * @param \AppBundle\Entity\FormAnswer $request
     */
    public function removeRequest(\AppBundle\Entity\FormAnswer $request)
    {
        $this->requests->removeElement($request);
    }

    /**
     * Get requests
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRequests()
    {
        return $this->requests;
    }


    /**
     * Is promo
     *
     * @return bool
     */
    public function getPromo()
    {
        return $this->getSelections()->containsKey($this->container->getParameter('promo_id'));
    }

    /**
     * Set isPromo
     *
     * @param bool $promo
     *
     * @return Item
     */
    public function setIsPromo($promo)
    {
        $this->isPromo = $promo;

        return $this;
    }

    /**
     * Get isPromo
     *
     * @return bool
     */
    public function getIsPromo()
    {
        return $this->isPromo;
    }

    /**
     * Set isAvailabile
     *
     * @param boolean $isAvailabile
     *
     * @return Item
     */
    public function setIsAvailabile($isAvailabile)
    {
        $this->isAvailabile = $isAvailabile;

        return $this;
    }

    /**
     * Get isAvailabile
     *
     * @return boolean
     */
    public function getIsAvailabile()
    {
        return $this->isAvailabile;
    }

    /**
     * Set delivery
     *
     * @param string $delivery
     *
     * @return Item
     */
    public function setDelivery($delivery)
    {
        $this->delivery = $delivery;

        return $this;
    }

    /**
     * Get delivery
     *
     * @return string
     */
    public function getDelivery()
    {
        return $this->delivery;
    }

    /**
     * Set payment
     *
     * @param string $payment
     *
     * @return Item
     */
    public function setPayment($payment)
    {
        $this->payment = $payment;

        return $this;
    }

    /**
     * Get payment
     *
     * @return string
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * Set condition
     *
     * @param string $condition
     *
     * @return Item
     */
    public function setCondition($condition)
    {
        $this->condition = $condition;

        return $this;
    }

    /**
     * Get condition
     *
     * @return string
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * Add color
     *
     * @param \AppBundle\Entity\ItemColor $color
     *
     * @return Item
     */
    public function addColor(\AppBundle\Entity\ItemColor $color)
    {
        $color->setItem($this);
        $this->colors[] = $color;

        return $this;
    }

    /**
     * Remove color
     *
     * @param \AppBundle\Entity\ItemColor $color
     */
    public function removeColor(\AppBundle\Entity\ItemColor $color)
    {
        $this->colors->removeElement($color);
    }

    /**
     * Get colors
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getColors()
    {
        return $this->colors;
    }

    /**
     * Get colors
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAllColors()
    {
        $result = [];

        if ($this->colors) {

            foreach ($this->colors as $i) {

                $result[$i->getColor()->getId()] = $i->getColor();
            }
        }

        return new ArrayCollection($result);
    }


    /**
     * Set canAskDiscount
     *
     * @param boolean $canAskDiscount
     *
     * @return Item
     */
    public function setCanAskDiscount($canAskDiscount)
    {
        $this->canAskDiscount = $canAskDiscount;

        return $this;
    }

    /**
     * Get canAskDiscount
     *
     * @return boolean
     */
    public function getCanAskDiscount()
    {
        return $this->canAskDiscount;
    }

    /**
     * Check item in favorites for user
     *
     * @return bool
     */
    public function inFavoriteForUser($user)
    {
        $result = false;

        if ($this->favorites) {

            foreach ($this->favorites as $i) {

                if ($i->getUser() == $user) {

                    $result = true;
                    break;
                }
            }
        }

        return $result;
    }
}
