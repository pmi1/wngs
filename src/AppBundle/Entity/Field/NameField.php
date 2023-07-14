<?php

namespace AppBundle\Entity\Field;

use Doctrine\ORM\Mapping as ORM;

/**
 * Трейт добавляет поле `имя` для сущности
 *
 *
 */
trait NameField
{
    /**
     * @var string Имя
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param null|string $name
     *
     * @return NameField
     */
    public function setName(string $name = null): self
    {
        $this->name = $name;

        return $this;
    }
}
