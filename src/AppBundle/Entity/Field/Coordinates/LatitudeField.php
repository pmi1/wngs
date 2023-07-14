<?php

namespace AppBundle\Entity\Field\Coordinates;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 */
trait LatitudeField
{
    /**
     * @var float|null Широта
     *
     * @ORM\Column(type="float", nullable=true, precision=10, scale=8)
     * @Assert\GreaterThanOrEqual(value="-90", message="Широта не может быть меньше чем -90")
     * @Assert\LessThanOrEqual(value="90", message="Широта не может быть больше чем 90")
     */
    private $latitude;

    /**
     * @return float|null
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param float|null $latitude
     *
     * @return LatitudeField
     */
    public function setLatitude(float $latitude = null)
    {
        $this->latitude = $latitude;

        return $this;
    }
}
