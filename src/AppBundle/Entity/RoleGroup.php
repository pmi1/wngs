<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="roles_group")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\RoleGroupRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class RoleGroup extends AbstractEntity
{
    /**
     * @var string Название
     *
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @var ArrayCollection|Privilege[] Привилегии
     *
     * @ORM\OneToMany(targetEntity="Privilege", mappedBy="roleGroups", cascade={"persist"})
     */
    protected $privileges;
    
    /**
     * @var \DateTime $deletedAt время удаления
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->privileges = new ArrayCollection();
    }
    
    /**
     * Get name as string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getname();
    }
    
    /**
     * Get roleGroupId.
     *
     * @return int
     */
    public function getRoleGroupId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return RoleGroup
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add privilege.
     *
     * @param Privilege $privilege
     *
     * @return RoleGroup
     */
    public function addPrivilege(Privilege $privilege)
    {
        $this->privileges[] = $privilege;

        return $this;
    }

    /**
     * Remove privilege.
     *
     * @param Privilege $privilege
     *
     * @return RoleGroup
     */
    public function removePrivilege(Privilege $privilege)
    {
        $this->privileges->removeElement($privilege);

        return $this;
    }

    /**
     * Get privileges.
     *
     * @return ArrayCollection
     */
    public function getPrivileges()
    {
        return $this->privileges;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     *
     * @return RoleGroup
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }
}
