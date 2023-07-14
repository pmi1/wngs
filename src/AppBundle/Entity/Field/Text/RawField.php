<?php

namespace AppBundle\Entity\Field\Text;

use Doctrine\ORM\Mapping as ORM;

/**
 * Трейт добавляет текст подробного описания в исходном формате
 *
 *
 */
trait RawField
{
    /**
     * @var string|null текст подробного описания в исходном формате
     *
     * @ORM\Column(name="raw", type="text", nullable=true)
     */
    private $raw;

    /**
     * @return null|string
     */
    public function getRaw()
    {
        return $this->raw;
    }

    /**
     * @param null|string $raw
     *
     * @return RawField
     */
    public function setRaw(string $raw = null): self
    {
        $this->raw = $raw;

        return $this;
    }
}
