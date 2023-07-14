<?php

namespace AppBundle\Entity;

use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * FormAnswer
 *
 * @ORM\Table(name="from_answer")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\FormAnswerRepository")
 */
class FormAnswer extends AbstractEntity
{
    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="requests")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true, onDelete="SET NULL"))
     */
    private $user;

    /**
     * @var Item
     *
     * @ORM\ManyToOne(targetEntity="Item", inversedBy="requests")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id", nullable=true, onDelete="SET NULL"))
     */
    private $item;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @Assert\Regex(
     *     pattern="/^[0-9\-\+\(\)\ ]+$/",
     *     message="Номер телефона имеет не допустимый формат"
     * )
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @Assert\Email(
     *     message = "'{{ value }}' не является адресом электронной почты",
     * )
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;
    
    /**
     * @var string
     *
     * @ORM\Column(name="question", type="text", nullable=true)
     */
    private $question;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;

    
    /**
     * @var \DateTime $answeredAt дата и время обращения
     *
     * @ORM\Column(name="answered_at", type="datetime", nullable=true)
     */
    private $answeredAt;
    
    /**
     * @var string
     *
     * @ORM\Column(name="referer_link", type="string", length=255, nullable=true)
     */
    private $refererLink;
    
    /**
     * @var int тип заполненной формы FormAnswerType
     *
     * @ORM\Column(name="form_type", type="integer", length=11, nullable=true)
     */
    private $formType;
    
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
     * Set name
     *
     * @param string $name
     *
     * @return FormAnswer
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return FormAnswer
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return FormAnswer
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set question
     *
     * @param string $question
     *
     * @return FormAnswer
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set refererLink
     *
     * @param string $refererLink
     *
     * @return FormAnswer
     */
    public function setRefererLink($refererLink)
    {
        $this->refererLink = $refererLink;

        return $this;
    }

    /**
     * Get refererLink
     *
     * @return string
     */
    public function getRefererLink()
    {
        return $this->refererLink;
    }


    /**
     * Set answeredAt
     *
     * @param \DateTime $answeredAt
     *
     * @return FormAnswer
     */
    public function setAnsweredAt($answeredAt)
    {
        $this->answeredAt = $answeredAt;

        return $this;
    }

    /**
     * Get answeredAt
     *
     * @return \DateTime
     */
    public function getAnsweredAt()
    {
        return $this->answeredAt;
    }

    /**
     * Set formType
     *
     * @param integer $formType
     *
     * @return FormAnswer
     */
    public function setFormType($formType)
    {
        $this->formType = $formType;

        return $this;
    }

    /**
     * Get formType
     *
     * @return integer
     */
    public function getFormType()
    {
        return $this->formType;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return FormAnswer
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return FormAnswer
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set item
     *
     * @param \AppBundle\Entity\Item $item
     *
     * @return FormAnswer
     */
    public function setItem(\AppBundle\Entity\Item $item = null)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get item
     *
     * @return \AppBundle\Entity\Item
     */
    public function getItem()
    {
        return $this->item;
    }
}
