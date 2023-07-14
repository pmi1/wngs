<?php

namespace AppBundle\Entity\Field;

use Doctrine\ORM\Mapping as ORM;

/**
 * Трейт добавляет поле сортировки
 */
trait OrderingField
{
    /**
     * @var int сортировка
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ordering;

    /**
     * @return int
     */
    public function getOrdering()
    {
        return $this->ordering;
    }

    /**
     * @param int $ordering
     *
     * @return OrderingField
     */
    public function setOrdering(string $ordering): self
    {
        $this->ordering = $ordering;

        return $this;
    }
}
