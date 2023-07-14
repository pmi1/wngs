<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Field\Datetime\CreatedAtField;
use AppBundle\Entity\Field\Datetime\DeletedAtField;
use AppBundle\Entity\Field\Datetime\UpdatedAtField;
use AppBundle\Entity\Field\NameField;
use AppBundle\Entity\Field\StatusField;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Тип пользователя
 *
 * @ORM\Table(name="user_type")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\UserTypeRepository")
  */
class UserType extends AbstractEntity
{
    use NameField;
    use StatusField;
    use UpdatedAtField;
    use CreatedAtField;

    /**
     * Get name as string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name ? $this->name : '';
    }

}
