<?php

namespace AppBundle\Entity\Embed;

use AppBundle\Entity\Field\Preview\FormattedField;
use AppBundle\Entity\Field\Preview\RawField;
use AppBundle\Entity\Field\Preview\TypeField;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 *
 *
 * @link http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/tutorials/embeddables.html
 */
class PreviewEmbed
{
    use RawField;
    use FormattedField;
    use TypeField;
}
