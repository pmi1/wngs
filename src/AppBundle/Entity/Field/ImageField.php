<?php

namespace AppBundle\Entity\Field;

use Doctrine\ORM\Mapping as ORM;
use Application\Sonata\MediaBundle\Entity\Media;

/**
 * Трейт добавляет изображение
 */
trait ImageField
{
    /**
     * @var Media
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media",cascade={"persist"})
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="image", referencedColumnName="id")
     * })
     */
    private $image;

    /**
     * Set image
     *
     * @param null|Media $image
     *
     * @return ImageField
     */
    public function setImage(Media $image = null): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return null|Media
     */
    public function getImage()
    {
        return $this->image;
    }
}
