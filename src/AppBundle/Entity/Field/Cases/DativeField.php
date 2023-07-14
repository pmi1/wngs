<?php

namespace AppBundle\Entity\Field\Cases;

use Doctrine\ORM\Mapping as ORM;

/**
 * Трейт добавляет поле с дательным падежом
 *
 *
 */
trait DativeField
{
    /**
     * @var string|null Дательный падеж
     *
     * @ORM\Column(name="dative", type="string", length=255, nullable=true)
     */
    private $dative;

    /**
     * @return null|string
     */
    public function getDative()
    {
        return $this->dative;
    }

    /**
     * @param null|string $dative
     *
     * @return DativeField
     */
    public function setDative(string $dative = null)
    {
        $this->dative = $dative;

        return $this;
    }
}
