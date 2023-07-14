<?php

namespace AppBundle\Entity\Embed;

use AppBundle\Entity\Field\Meta\DescriptionField;
use AppBundle\Entity\Field\Meta\KeywordsField;
use AppBundle\Entity\Field\Meta\TitleField;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 *
 *
 * @link http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/tutorials/embeddables.html
 */
class MetaEmbed
{
    use TitleField;
    use DescriptionField;
    use KeywordsField;
}
