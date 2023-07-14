<?php

namespace AppBundle\Entity\Field\Text;

use AppBundle\Entity\Embed\TextEmbed;
use Doctrine\ORM\Mapping as ORM;

/**
 * Трейт добавляет поле с текстом подробное содержание
 *
 *
 */
trait TextField
{
    /**
     * @var TextEmbed Текст с подробным содержанием
     *
     * @ORM\Embedded(class="AppBundle\Entity\Embed\TextEmbed", columnPrefix="text_")
     */
    private $text;
    
    /**
     * @return TextEmbed
     */
    public function getText(): TextEmbed
    {
        return $this->text;
    }

    /**
     * @param TextEmbed $text
     *
     * @return mixed
     */
    public function setText(TextEmbed $text): self
    {
        $this->text = $text;

        return $this;
    }
}
