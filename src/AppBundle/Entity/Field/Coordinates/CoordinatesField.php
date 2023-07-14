<?php

namespace AppBundle\Entity\Field\Coordinates;

use AppBundle\Entity\Embed\CoordinatesEmbed;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 */
trait CoordinatesField
{
    /**
     * @var CoordinatesEmbed Координаты
     *
     * @ORM\Embedded(class="AppBundle\Entity\Embed\CoordinatesEmbed", columnPrefix="coordinates_")
     */
    private $coordinates;

    /**
     * @return CoordinatesEmbed
     */
    public function getCoordinates(): CoordinatesEmbed
    {
        return $this->coordinates;
    }

    /**
     * @param CoordinatesEmbed $coordinates
     *
     * @return CoordinatesField
     */
    public function setCoordinates(CoordinatesEmbed $coordinates): self
    {
        $this->coordinates = $coordinates;

        return $this;
    }
}
