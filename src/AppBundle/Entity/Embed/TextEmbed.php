<?php

namespace AppBundle\Entity\Embed;

use AppBundle\Entity\Field\Text\FormattedField;
use AppBundle\Entity\Field\Text\RawField;
use AppBundle\Entity\Field\Text\TypeField;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 *
 *
 * @link http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/tutorials/embeddables.html
 */
class TextEmbed
{
    use RawField;
    use FormattedField;
    use TypeField;
}
