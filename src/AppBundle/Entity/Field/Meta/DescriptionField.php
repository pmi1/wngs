<?php

namespace AppBundle\Entity\Field\Meta;

use Doctrine\ORM\Mapping as ORM;

/**
 * Трейт добавляет поле мета описание для страницы
 *
 *
 */
trait DescriptionField
{
    /**
     * @var string|null Мета описание
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @return null|string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param null|string $description
     *
     * @return DescriptionField
     */
    public function setDescription(string $description = null): self
    {
        $this->description = $description;

        return $this;
    }
}
