<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Item;
use AppBundle\Entity\Color;

/**
 * ItemColor
 *
 * @ORM\Table(name="item_color")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\ItemColorRepository")
 *
 * Связь товара с цветами
 */
class ItemColor extends AbstractEntity
{
    /**
     * @var Item
     *
     * @ORM\ManyToOne(targetEntity="Item", inversedBy="colors")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id")
     */
    private $item;
    
    /**
     * @var Color
     *
     * @ORM\ManyToOne(targetEntity="Color", inversedBy="items")
     * @ORM\JoinColumn(name="color_id", referencedColumnName="id")
     */
    private $color;

    /**
     * Get name as string
     *
      * @return string
     */
    public function __toString()
    {
        return $this->color ? $this->color->getName() : '';
    }

    /**
     * Set item
     *
     * @param Item $item
     *
     * @return ItemColor
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
     * Set color
     *
     * @param Color $color
     *
     * @return ItemColor
     */
    public function setColor(Color $color = null)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return Color
     */
    public function getColor()
    {
        return $this->color;
    }
}
