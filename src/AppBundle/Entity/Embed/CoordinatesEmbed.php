<?php

namespace AppBundle\Entity\Embed;

use AppBundle\Entity\Field\Coordinates\LatitudeField;
use AppBundle\Entity\Field\Coordinates\LongitudeField;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 *
 *
 * @link http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/tutorials/embeddables.html
 */
class CoordinatesEmbed
{
    use LongitudeField;
    use LatitudeField;
}
