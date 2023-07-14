<?php

namespace AppBundle\Entity\Field\Coordinates;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 */
trait LongitudeField
{
    /**
     * @var float|null Долгота
     *
     * @ORM\Column(type="float", nullable=true, precision=11, scale=8)
     * @Assert\GreaterThanOrEqual(value="-180", message="Долгота не может быть меньше чем -180")
     * @Assert\LessThanOrEqual(value="180", message="Долгота не может быть больше чем 180")
     */
    private $longitude;

    /**
     * @return float|null
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param float|null $longitude
     *
     * @return LongitudeField
     */
    public function setLongitude(float $longitude = null)
    {
        $this->longitude = $longitude;

        return $this;
    }
}
