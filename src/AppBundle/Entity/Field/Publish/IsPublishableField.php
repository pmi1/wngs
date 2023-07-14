<?php

namespace AppBundle\Entity\Field\Publish;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 */
trait IsPublishableField
{
    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false, options={"default": true}, name="is_publishable")
     */
    private $isPublishable = true;

    /**
     * @return bool
     */
    public function isPublishable(): bool
    {
        return $this->isPublishable;
    }

    /**
     * @param bool $isPublishable
     *
     * @return IsPublishableField
     */
    public function setIsPublishable(bool $isPublishable): self
    {
        $this->isPublishable = $isPublishable;

        return $this;
    }
}
