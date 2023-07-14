<?php

namespace AppBundle\Entity\Field\Preview;

use Doctrine\ORM\Mapping as ORM;

/**
 * Трейт добавляет текст краткого описания в исходном формате
 *
 *
 */
trait RawField
{
    /**
     * @var string|null текст краткого описания в исходном формате
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
