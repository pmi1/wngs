<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CmfScript.
 *
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\CmfConfigureRepository")
 *
 * Таблица для хранения конфигурации отображения полей сущности в списке в административном разделе
 * Используется только для список в административном разделе
 */
class CmfConfigure extends AbstractEntity
{
    /**
     * @var int ID пользователя, который настроил для себя внешний вид
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * @var string Сущность, к которой применяются настройки пользователя
     *
     * @ORM\Column(name="script_name", type="string", length=255)
     */
    private $scriptName;

    /**
     * @var string Поле, которое будет отображаться в списке
     *
     * @ORM\Column(name="field_name", type="string", length=255)
     */
    private $fieldName;

    /**
     * @var int сортировка полей при выводе
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ordering;

    /**
     * @var bool Флаг видимости поля, спрятано поле или нет
     *
     * @ORM\Column(name="is_visuality", type="boolean", nullable=true, options={"default" = false})
     */
    private $isVisuality;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->isVisuality = false;
    }
    /**
     * Set userId.
     *
     * @param int $userId
     *
     * @return CmfConfigure
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId.
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set scriptName.
     *
     * @param string $scriptName
     *
     * @return CmfConfigure
     */
    public function setScriptName($scriptName)
    {
        $this->scriptName = $scriptName;

        return $this;
    }

    /**
     * Get scriptName.
     *
     * @return string
     */
    public function getScriptName()
    {
        return $this->scriptName;
    }

    /**
     * Set fieldName.
     *
     * @param string $fieldName
     *
     * @return CmfConfigure
     */
    public function setFieldName($fieldName)
    {
        $this->fieldName = $fieldName;

        return $this;
    }

    /**
     * Get fieldName.
     *
     * @return string
     */
    public function getFieldName()
    {
        return $this->fieldName;
    }

    /**
     * Set ordering.
     *
     * @param int $ordering
     *
     * @return CmfConfigure
     */
    public function setOrdering($ordering)
    {
        $this->ordering = $ordering;

        return $this;
    }

    /**
     * Get ordering.
     *
     * @return int
     */
    public function getOrdering()
    {
        return $this->ordering;
    }

    /**
     * Set isVisuality.
     *
     * @param bool $isVisuality
     *
     * @return CmfConfigure
     */
    public function setIsVisuality($isVisuality)
    {
        $this->isVisuality = $isVisuality;

        return $this;
    }

    /**
     * Get isVisuality.
     *
     * @return bool
     */
    public function getIsVisuality()
    {
        return $this->isVisuality;
    }
}
