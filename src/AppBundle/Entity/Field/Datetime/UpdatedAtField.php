<?php

namespace AppBundle\Entity\Field\Datetime;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 *
 */
trait UpdatedAtField
{
    /**
     * @var \DateTime Время обновления информации о сущности
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false, options={"default": 0})
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     *
     * @return UpdatedAtField
     */
    public function setUpdatedAt(\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
