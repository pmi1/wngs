<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Field\NameField;
use AppBundle\Entity\Field\ImageField;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Application\Sonata\MediaBundle\Entity\Gallery;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Article
 *
 * @ORM\Table(name="color")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\ColorRepository")
 *
 * Цвета
 */
class Color extends AbstractEntity
{
    use NameField;
    use ImageField;

    /**
     * @var ArrayCollection|ItemColor[]
     *
     * @ORM\OneToMany(targetEntity="ItemColor", mappedBy="color", cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC"})
     */
    private $items;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    /**
     * Get name as string
     
     * @return string
     */
    public function __toString()
    {
        return $this->name ? $this->name : '';
    }
}