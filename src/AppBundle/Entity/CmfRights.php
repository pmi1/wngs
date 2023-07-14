<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="cmf_rights")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\CmfRightsRepository")
 *
 * Таблица для хранения прав доступа для определенной комбинации ролей
 */
class CmfRights extends AbstractEntity
{
    /**
     * @var string Хэш комбинации ролей (напр. md5('ROLE_1'.'ROLE_2'.'ROLE_3'))
     *
     * @ORM\Column(name="cmf_role_group_combination_id", type="string", length=41, options={"fixed" = true})
     */
    private $cmfRoleGroupCombinationId;

     /**
      * @var int Раздел из CmfScript
      *
      * @ORM\ManyToOne(targetEntity="CmfScript", cascade={"remove"})
      * @ORM\JoinColumn(name="script_id", referencedColumnName="id", nullable=false, onDelete="cascade")
      */
    private $script;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_read", type="boolean", nullable=true, options={"default" : 0})
     */
    private $isRead;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_write", type="boolean", nullable=true, options={"default" : 0})
     */
    private $isWrite;

    /**
     * @var bool Есть права на добавление элемента?
     *
     * @ORM\Column(name="is_insert", type="boolean", nullable=true, options={"default" : 0})
     */
    private $isInsert;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_delete", type="boolean", nullable=true, options={"default" : 0})
     */
    private $isDelete;

    /**
     * Set cmfRoleGroupCombinationId.
     *
     * @param string $cmfRoleGroupCombinationId
     *
     * @return CmfRights
     */
    public function setCmfRoleGroupCombinationId($cmfRoleGroupCombinationId)
    {
        $this->cmfRoleGroupCombinationId = $cmfRoleGroupCombinationId;

        return $this;
    }

    /**
     * Get cmfRoleGroupCombinationId.
     *
     * @return string
     */
    public function getCmfRoleGroupCombinationId()
    {
        return $this->cmfRoleGroupCombinationId;
    }

    /**
     * Set isRead.
     *
     * @param bool $isRead
     *
     * @return CmfRights
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
     * @return CmfRights
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
     * @return CmfRights
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
     * @return CmfRights
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
     * Set script.
     *
     * @param CmfScript $script
     *
     * @return CmfRights
     */
    public function setScript(CmfScript $script)
    {
        $this->script = $script;

        return $this;
    }

    /**
     * Get script.
     *
     * @return CmfScript
     */
    public function getScript()
    {
        return $this->script;
    }
}
