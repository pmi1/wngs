<?php

namespace AppBundle\Entity\Field\Cases;

use Doctrine\ORM\Mapping as ORM;

/**
 * Трейт добавляет поле с родительным падежом
 *
 *
 */
trait GenitiveField
{
    /**
     * @var string|null Родительный падеж
     *
     * @ORM\Column(name="genitive", type="string", length=255, nullable=true)
     */
    private $genitive;

    /**
     * @return null|string
     */
    public function getGenitive()
    {
        return $this->genitive;
    }

    /**
     * @param null|string $genitive
     *
     * @return GenitiveField
     */
    public function setGenitive(string $genitive = null)
    {
        $this->genitive = $genitive;

        return $this;
    }
}
