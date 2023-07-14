<?php

namespace AppBundle\Entity\Field\Cases;

use Doctrine\ORM\Mapping as ORM;

/**
 * Трейт добавляет поле с творительным падежом
 *
 *
 */
trait InstrumentalField
{
    /**
     * @var string|null Творительный падеж
     *
     * @ORM\Column(name="instrumental", type="string", length=255, nullable=true)
     */
    private $instrumental;

    /**
     * @return null|string
     */
    public function getInstrumental()
    {
        return $this->instrumental;
    }

    /**
     * @param null|string $instrumental
     *
     * @return InstrumentalField
     */
    public function setInstrumental(string $instrumental = null)
    {
        $this->instrumental = $instrumental;

        return $this;
    }
}
