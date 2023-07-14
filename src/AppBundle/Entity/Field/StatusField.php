<?php

namespace AppBundle\Entity\Field;

use Doctrine\ORM\Mapping as ORM;

/**
 * Трейт добавляет поле статус для сущности
 *
 *
 */
trait StatusField
{
    /**
     * @var bool Статус
     *
     * @ORM\Column(name="status", type="boolean", nullable=false, options={"default": 1})
     */
    private $status = true;

    /**
     * @return bool
     */
    public function isStatus(): bool
    {
        return $this->status;
    }

    /**
     * @return bool
     */
    public function getStatus(): bool
    {
        return $this->status;
    }

    /**
     * @param bool $status
     *
     * @return StatusField
     */
    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }
}
