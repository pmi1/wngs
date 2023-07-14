<?php

namespace AppBundle\Entity\Field\Preview;

use Doctrine\ORM\Mapping as ORM;

/**
 * Трейт добавляет текст краткого описания, отформатированный для клиентской части
 *
 *
 */
trait FormattedField
{
    /**
     * @var string|null текст краткого описания, отформатированный для клиентской части
     *
     * @ORM\Column(name="formatted", type="text", nullable=true)
     */
    private $formatted;

    /**
     * @return null|string
     */
    public function getFormatted()
    {
        return $this->formatted;
    }

    /**
     * @param null|string $formatted
     *
     * @return FormattedField
     */
    public function setFormatted(string $formatted = null): self
    {
        $this->formatted = $formatted;

        return $this;
    }
}
