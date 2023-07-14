<?php

namespace AppBundle\Entity\Field\Meta;

use AppBundle\Entity\Embed\MetaEmbed;
use Doctrine\ORM\Mapping as ORM;

/**
 * Трейт добавляет поле с мета информацией
 *
 *
 */
trait MetaField
{
    /**
     * @var MetaEmbed Мета класс
     *
     * @ORM\Embedded(class="AppBundle\Entity\Embed\MetaEmbed", columnPrefix="meta_")
     */
    private $meta;

    /**
     * @return MetaEmbed
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * @param MetaEmbed $meta
     *
     * @return mixed
     */
    public function setMeta(MetaEmbed $meta): self
    {
        $this->meta = $meta;

        return $this;
    }
}
