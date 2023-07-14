<?php

namespace AppBundle\Entity\Field;

use Doctrine\ORM\Mapping as ORM;

/**
 * Трейт добавляет поле ID для сущности
 *
 *
 */
trait IdField
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param null|int $id
     *
     * @return IdField
     */
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }
}
