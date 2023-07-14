<?php

namespace AppBundle\Entity\Field;

use Doctrine\ORM\Mapping as ORM;

/**
 * Трейт добавляет заголовок h1 для страницы
 *
 *
 */
trait H1Field
{
    /**
     * @var string|null Заголовок h1 на странице
     *
     * @ORM\Column(name="h1", type="string", length=255, nullable=true)
     */
    private $h1;

    /**
     * @return null|string
     */
    public function getH1()
    {
        return $this->h1;
    }

    /**
     * @param null|string $h1
     *
     * @return H1Field
     */
    public function setH1($h1): self
    {
        $this->h1 = $h1;

        return $this;
    }
}
