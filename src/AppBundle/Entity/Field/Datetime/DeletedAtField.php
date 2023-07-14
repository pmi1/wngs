<?php

namespace AppBundle\Entity\Field\Datetime;

use Doctrine\ORM\Mapping as ORM;

/**
 * Трейт добавляет поле deletedAt, используемое SoftDeleteable
 *
 *
 */
trait DeletedAtField
{
    /**
     * @var \DateTime Время удаления сущности
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;
    
    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     *
     * @return mixed
     */
    public function setDeletedAt(\DateTime $deletedAt = null): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }
}
