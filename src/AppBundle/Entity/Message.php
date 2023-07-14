<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use AppBundle\Entity\Field\NameField;
use AppBundle\Entity\Field\Meta\DescriptionField;

/**
 * Message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\MessageRepository")
 *
 * Сообщения
 */
class Message extends AbstractEntity
{
    use NameField;
    use DescriptionField;

    /**
     * @var Order
     *
     * @ORM\ManyToOne(targetEntity="Order", inversedBy="messages")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     */
    private $order;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_from", referencedColumnName="id", onDelete="SET NULL")
     */
    private $from;
    
    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_to", referencedColumnName="id", onDelete="SET NULL")
     */
    private $to;

    /**
     * @var \DateTime $cdate Дата размещения
     *
     * @ORM\Column(name="cdate", type="datetime", nullable=true)
     */
    private $cdate;

    /**
     * @var \integer $eventType Тип сообщения
     *
     * @ORM\Column(name="event_type", type="integer", nullable=true)
     */
    private $eventType;

    /**
     * @var \boolean $isNew Флаг сообщения (прочитано/не прочитано)
     *
     * @ORM\Column(name="is_new", type="boolean", nullable=true)
     */
    private $isNew = 1;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->status = false;
    }

    /**
     * Get name as string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name ? $this->name : '';
    }

    /**
     * Set eventType
     *
     * @param integer $eventType
     *
     * @return Message
     */
    public function setEventType($eventType)
    {
        $this->eventType = $eventType;

        return $this;
    }

    /**
     * Get eventType
     *
     * @return integer
     */
    public function getEventType()
    {
        return $this->eventType;
    }

    /**
     * Set isNew
     *
     * @param \smallint $isNew
     *
     * @return Message
     */
    public function setIsNew($isNew)
    {
        $this->isNew = $isNew;

        return $this;
    }

    /**
     * Get isNew
     *
     * @return \integer
     */
    public function getIsNew()
    {
        return $this->isNew;
    }

    /**
     * Set cdate
     *
     * @param \DateTime $cdate
     *
     * @return Message
     */
    public function setCdate($cdate)
    {
        $this->cdate = $cdate;

        return $this;
    }

    /**
     * Get cdate
     *
     * @return \DateTime
     */
    public function getCdate()
    {
        return $this->cdate;
    }

    /**
     * Set order
     *
     * @param \AppBundle\Entity\Order $order
     *
     * @return Message
     */
    public function setOrder(\AppBundle\Entity\Order $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \AppBundle\Entity\Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set from
     *
     * @param \AppBundle\Entity\User $from
     *
     * @return Message
     */
    public function setFrom(\AppBundle\Entity\User $from = null)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Get from
     *
     * @return \AppBundle\Entity\User
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Set to
     *
     * @param \AppBundle\Entity\User $to
     *
     * @return Message
     */
    public function setTo(\AppBundle\Entity\User $to = null)
    {
        $this->to = $to;

        return $this;
    }

    /**
     * Get to
     *
     * @return \AppBundle\Entity\User
     */
    public function getTo()
    {
        return $this->to;
    }
}
