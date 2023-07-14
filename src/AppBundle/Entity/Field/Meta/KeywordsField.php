<?php

namespace AppBundle\Entity\Field\Meta;

use Doctrine\ORM\Mapping as ORM;

/**
 * Трейт добавляет поле с ключевыми словами для страницы
 *
 *
 */
trait KeywordsField
{
    /**
     * @var string|null Ключевые слова
     *
     * @ORM\Column(name="keywords", type="text", nullable=true)
     */
    private $keywords;

    /**
     * @return null|string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @param null|string $keywords
     *
     * @return KeywordsField
     */
    public function setKeywords(string $keywords = null): self
    {
        $this->keywords = $keywords;

        return $this;
    }
}
