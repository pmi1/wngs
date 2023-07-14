<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="privilege")
 *
 * Привилегии
 */
class Privilege extends AbstractEntity
{
    /**
     * @var RoleGroup
     *
     * @ORM\ManyToOne(targetEntity="RoleGroup", inversedBy="privileges")
     * @ORM\JoinColumn(name="roles_group_id", referencedColumnName="id", nullable=false)
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $roleGroups;

    /**
     * @var Role
     *
     * @ORM\ManyToOne(targetEntity="Role", inversedBy="privileges")
     * @ORM\JoinColumn(name="role_id", referencedColumnName="id", nullable=false)
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $roles;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_read", type="boolean", options={"default" = false})
     */
    private $isRead;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_write", type="boolean", options={"default" = false})
     */
    private $isWrite;

    /**
     * @var bool Права на создание элементов
     *
     * @ORM\Column(name="is_insert", type="boolean", options={"default" = false})
     */
    private $isInsert;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_delete", type="boolean", options={"default" = false})
     */
    private $isDelete;
        
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->isRead = false;
        $this->isWrite = false;
        $this->isInsert = false;
        $this->isDelete = false;
    }
    
    /**
     * Set isRead.
     *
     * @param bool $isRead
     *
     * @return Privilege
     */
    public function setIsRead($isRead)
    {
        $this->isRead = $isRead;

        return $this;
    }

    /**
     * Get isRead.
     *
     * @return bool
     */
    public function getIsRead()
    {
        return $this->isRead;
    }

    /**
     * Set isWrite.
     *
     * @param bool $isWrite
     *
     * @return Privilege
     */
    public function setIsWrite($isWrite)
    {
        $this->isWrite = $isWrite;

        return $this;
    }

    /**
     * Get isWrite.
     *
     * @return bool
     */
    public function getIsWrite()
    {
        return $this->isWrite;
    }

    /**
     * Set isInsert.
     *
     * @param bool $isInsert
     *
     * @return Privilege
     */
    public function setIsInsert($isInsert)
    {
        $this->isInsert = $isInsert;

        return $this;
    }

    /**
     * Get isInsert.
     *
     * @return bool
     */
    public function getIsInsert()
    {
        return $this->isInsert;
    }

    /**
     * Set isDelete.
     *
     * @param bool $isDelete
     *
     * @return Privilege
     */
    public function setIsDelete($isDelete)
    {
        $this->isDelete = $isDelete;

        return $this;
    }

    /**
     * Get isDelete.
     *
     * @return bool
     */
    public function getIsDelete()
    {
        return $this->isDelete;
    }

    /**
     * Set roleGroups.
     *
     * @param RoleGroup $roleGroups
     *
     * @return Privilege
     */
    public function setRoleGroups(RoleGroup $roleGroups)
    {
        $this->roleGroups = $roleGroups;

        return $this;
    }

    /**
     * Get roleGroups.
     *
     * @return RoleGroup
     */
    public function getRoleGroups()
    {
        return $this->roleGroups;
    }

    /**
     * Set roles.
     *
     * @param Role $roles
     *
     * @return Privilege
     */
    public function setRoles(Role $roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles.
     *
     * @return Role
     */
    public function getRoles()
    {
        return $this->roles;
    }
}
