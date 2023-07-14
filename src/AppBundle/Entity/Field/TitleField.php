<?php

namespace AppBundle\Entity\Field;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 */
trait TitleField
{
    /**
     * @var string Заголовок
     *
     * @ORM\Column()
     */
    private $title;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return TitleField
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
