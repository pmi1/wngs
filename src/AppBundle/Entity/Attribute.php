<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Application\Sonata\MediaBundle\Entity\Gallery;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Attribute
 *
 * @ORM\Table(name="attribute")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\AttributeRepository")
 *
 * Статьи
 */
class Attribute extends AbstractEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var ArrayCollection|ItemAttribute[]
     *
     * @ORM\OneToMany(targetEntity="ItemAttribute", mappedBy="attribute", cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC"})
     */
    private $itemAttributes;

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
        return $this->name;
    }


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Attribute
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
}
