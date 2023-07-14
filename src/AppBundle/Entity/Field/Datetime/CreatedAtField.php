<?php

namespace AppBundle\Entity\Field\Datetime;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 *
 */
trait CreatedAtField
{
    /**
     * @var \Datetime Время создания сущности
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false, options={"default": 0})
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @return \Datetime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \Datetime $createdAt
     *
     * @return CreatedAtField
     */
    public function setCreatedAt(\Datetime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
