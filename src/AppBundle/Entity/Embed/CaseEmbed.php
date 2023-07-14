<?php

namespace AppBundle\Entity\Embed;

use AppBundle\Entity\Field\Cases\DativeField;
use AppBundle\Entity\Field\Cases\GenitiveField;
use AppBundle\Entity\Field\Cases\InstrumentalField;
use AppBundle\Entity\Field\Cases\NominativeField;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 *
 *
 * @link http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/tutorials/embeddables.html
 */
class CaseEmbed
{
    use NominativeField;
    use GenitiveField;
    use DativeField;
    use InstrumentalField;
}
