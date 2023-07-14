<?php

namespace AppBundle\Entity\Field\Text;

use Doctrine\ORM\Mapping as ORM;

/**
 * Трейт добавляет текст подробного описания, отформатированный для клиентской части
 *
 *
 */
trait FormattedField
{
    /**
     * @var string|null
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
