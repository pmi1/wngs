<?php

namespace AppBundle\Entity\Field;

use Doctrine\ORM\Mapping as ORM;

/**
 * Трейт добавляет поле ссылка для сущности
 *
 *
 */
trait LinkField
{
    /**
     * @var string|null Ссылка
     *
     * @ORM\Column(name="link", type="string", length=255, nullable=true)
     */
    private $link;

    /**
     * @return null|string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param null|string $link
     *
     * @return LinkField
     */
    public function setLink(string $link = null): self
    {
        $this->link = $link;

        return $this;
    }
}
