<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Role.
 *
 * @ORM\Table(name="role")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\RoleRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 *
 * Роли
 */
class Role extends AbstractEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var bool
     *
     * @ORM\Column(name="status", type="boolean", options={"default" = false})
     */
    private $status;

    /**
     * @var ArrayCollection|CmfScript[] Коллекция разделов сайта
     *
     * @ORM\ManyToMany(targetEntity="CmfScript", inversedBy="roles")
     * @ORM\JoinTable(name="role_script",
     *   joinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="cmf_script_id", referencedColumnName="id")}
     * )
     */
    private $cmfScripts;

    /**
     * @var ArrayCollection|Privilege[] Привилегии
     *
     * @ORM\OneToMany(targetEntity="Privilege", mappedBy="roles")
     */
    protected $privileges;
    
    /**
     * @var \DateTime $deletedAt время удаления
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cmfScripts = new ArrayCollection();
        $this->privileges = new ArrayCollection();
        $this->status = false;
    }

    /**
     * Get name as string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Role
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
     * Set status.
     *
     * @param bool $status
     *
     * @return Role
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return bool
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Add cmfScript.
     *
     * @param CmfScript $cmfScript
     *
     * @return Role
     */
    public function addCmfScript(CmfScript $cmfScript)
    {
        $this->cmfScripts[] = $cmfScript;

        return $this;
    }

    /**
     * Remove cmfScript.
     *
     * @param CmfScript $cmfScript
     *
     * @return Role
     */
    public function removeCmfScript(CmfScript $cmfScript)
    {
        $this->cmfScripts->removeElement($cmfScript);

        return $this;
    }

    /**
     * Get cmfScripts.
     *
     * @return ArrayCollection
     */
    public function getCmfScripts()
    {
        return $this->cmfScripts;
    }

    /**
     * Add privilege.
     *
     * @param Privilege $privilege
     *
     * @return Role
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
     * @return Role
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
     * @return Role
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
