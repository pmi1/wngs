<?php

namespace AppBundle\Entity\Field\Text;

use Doctrine\ORM\Mapping as ORM;

/**
 * Трейт добавляет тип визуального редактора для поля с подробным описанием
 *
 *
 */
trait TypeField
{
    /**
     * @var string|null Тип визуального редактора для поля с подробным описанием
     *
     * @ORM\Column(name="type", type="text", nullable=true)
     */
    private $type;

    /**
     * @return null|string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param null|string $type
     *
     * @return TypeField
     */
    public function setType(string $type = null): self
    {
        $this->type = $type;

        return $this;
    }
}
