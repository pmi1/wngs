<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Item;
use AppBundle\Entity\Attribute;

/**
 * ItemAttribute
 *
 * @ORM\Table(name="item_attribute")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\ItemAttributeRepository")
 *
 * Связь товара с характеристиками
 */
class ItemAttribute extends AbstractEntity
{
    /**
     * @var Item
     *
     * @ORM\ManyToOne(targetEntity="Item", inversedBy="itemAttributes")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id")
     */
    private $item;
    
    /**
     * @var Attribute
     *
     * @ORM\ManyToOne(targetEntity="Attribute", inversedBy="itemAttributes")
     * @ORM\JoinColumn(name="attribute_id", referencedColumnName="id")
     */
    private $attribute;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=255, nullable=true)
     */
    private $value;

    /**
     * Get name as string
     *
      * @return string
     */
    public function __toString()
    {
        return '1';
    }

    /**
     * Set item
     *
     * @param Item $item
     *
     * @return ItemAttribute
     */
    public function setItem(Item $item = null)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get item
     *
     * @return Item
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Set attribute
     *
     * @param Attribute $attribute
     *
     * @return ItemAttribute
     */
    public function setAttribute(Attribute $attribute = null)
    {
        $this->attribute = $attribute;

        return $this;
    }

    /**
     * Get attribute
     *
     * @return Attribute
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return ItemAttribute
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}
