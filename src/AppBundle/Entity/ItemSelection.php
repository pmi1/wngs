<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Field\Datetime\CreatedAtField;
use AppBundle\Entity\Field\StatusField;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Item;
use AppBundle\Entity\Selection;

/**
 * ItemSelection
 *
 * @ORM\Table(name="item_selection")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\ItemSelectionRepository")
 *
 * Связь товара с выборками
 */
class ItemSelection extends AbstractEntity
{

    use StatusField;
    use CreatedAtField;

    /**
     * @var Item
     *
     * @ORM\ManyToOne(targetEntity="Item", inversedBy="itemSelections")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id")
     */
    private $item;
    
    /**
     * @var Selection
     *
     * @ORM\ManyToOne(targetEntity="Selection", inversedBy="itemSelections")
     * @ORM\JoinColumn(name="selection_id", referencedColumnName="id")
     */
    private $selection;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->status = false;
        $this->setCreatedAt(new \DateTime());
    }

    /**
     * Get name as string
     *
      * @return string
     */
    public function __toString()
    {
        return $this->selection ? $this->selection->getName() : '1';
    }

    /**
     * Set item
     *
     * @param Item $item
     *
     * @return ItemSelection
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
     * Set selection
     *
     * @param \AppBundle\Entity\Selection $selection
     *
     * @return ItemSelection
     */
    public function setSelection(\AppBundle\Entity\Selection $selection = null)
    {
        $this->selection = $selection;

        return $this;
    }

    /**
     * Get selection
     *
     * @return \AppBundle\Entity\Selection
     */
    public function getSelection()
    {
        return $this->selection;
    }
}
