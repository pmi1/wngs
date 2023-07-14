<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Item;
use AppBundle\Entity\Catalogue;
use AppBundle\Entity\Field\Datetime\DeletedAtField;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * ItemCatalogue
 *
 * @ORM\Table(name="item_catalogue")
 * @UniqueEntity(fields={"catalogue", "item"})
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\ItemCatalogueRepository")
 *
 * Товар - рубрики
 */
class ItemCatalogue extends AbstractEntity
{
    /**
     * @var Item
     *
     * @ORM\ManyToOne(targetEntity="Item", inversedBy="catalogues")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id")
     */
    private $item;
    
    /**
     * @var Catalogue
     *
     * @ORM\ManyToOne(targetEntity="Catalogue", inversedBy="itemCatalogues")
     * @ORM\JoinColumn(name="catalogue_id", referencedColumnName="id")
     */
    private $catalogue;


    /**
     * Get name as string
     *
      * @return string
     */
    public function __toString()
    {
        return $this->catalogue->getName();
    }

    /**
     * Set item
     *
     * @param Item $item
     *
     * @return CatalogueFavorite
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
     * Set catalogue
     *
     * @param \AppBundle\Entity\Catalogue $catalogue
     *
     * @return ItemCatalogue
     */
    public function setCatalogue(\AppBundle\Entity\Catalogue $catalogue = null)
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
}
