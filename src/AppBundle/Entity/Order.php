<?php

namespace AppBundle\Entity;

use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Order
 *
 * @ORM\Table(name="`order`")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\OrderRepository")
 */
class Order extends AbstractEntity
{
    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="orders")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true, onDelete="SET NULL"))
     */
    private $user;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="brandOrders")
     * @ORM\JoinColumn(name="executor_id", referencedColumnName="id", nullable=true, onDelete="SET NULL"))
     */
    private $executor;

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
     * @ORM\Column(name="price", type="integer", length=11, nullable=true)
     * @Assert\GreaterThanOrEqual(value="0", message="Значение цены не может быть меньше 0")
     */
    private $price;

    /**
     * @var smallint Значение скидки в процентах
     *
     * @ORM\Column(name="discount", type="smallint", nullable=true)
     * @Assert\LessThanOrEqual(value="99", message="Значение скидки не может превышать 99%")
     * @Assert\GreaterThanOrEqual(value="0", message="Значение скидки не может быть меньше 0%")
     */
    private $discount;

    /**
     * @var string
     *
     * @ORM\Column(name="delivery", type="string", length=255, nullable=true)
     */
    private $delivery;

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
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="zip", type="string", length=255, nullable=true)
     */
    private $zip;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=255, nullable=true)
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(name="building", type="string", length=255, nullable=true)
     */
    private $building;

    /**
     * @var string
     *
     * @ORM\Column(name="apartment", type="string", length=255, nullable=true)
     */
    private $apartment;

    /**
     * @var \DateTime $cdate дата и время обращения
     *
     * @ORM\Column(name="cdate", type="datetime", nullable=true)
     */
    private $cdate;

    /**
     * @var int тип заполненной формы OrderType
     *
     * @ORM\Column(name="form_type", type="integer", length=11, nullable=true)
     */
    private $formType;

    /**
     * @var int тип заполненной формы OrderType
     *
     * @ORM\Column(name="status", type="integer", length=11, nullable=true, options={"default" = 1})
     */
    private $status;

    /**
     * @var ArrayCollection|UserFavorite[]
     *
     * @ORM\OneToMany(targetEntity="Message", mappedBy="order", cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */

    private $messages;

    /**
     * @var Delivery
     *
     * @ORM\ManyToOne(targetEntity="Delivery", inversedBy="orders")
     * @ORM\JoinColumn(name="delivery_id", referencedColumnName="id", nullable=true, onDelete="SET NULL"))
     */
    private $deliveryType;

    /**
     * @var Review
     *
     * @ORM\OneToOne(targetEntity="Review", mappedBy="order")
     */
    private $review;

    /**
     * Get name as string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->id ? (string)$this->id : '';
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Order
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
     * @return Order
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
     * @return Order
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
     * @return Order
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
     * Set cdate
     *
     * @param \DateTime $cdate
     *
     * @return Order
     */
    public function setcdate($cdate)
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
     * Set formType
     *
     * @param integer $formType
     *
     * @return Order
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
     * @return Order
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
     * @return Order
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
     * @return Order
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

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Order
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set discount
     *
     * @param integer $discount
     *
     * @return Order
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * Get discount
     *
     * @return integer
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Set delivery
     *
     * @param string $delivery
     *
     * @return Order
     */
    public function setDelivery($delivery)
    {
        $this->delivery = $delivery;

        return $this;
    }

    /**
     * Get delivery
     *
     * @return string
     */
    public function getDelivery()
    {
        return $this->delivery;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Order
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set executor
     *
     * @param \AppBundle\Entity\User $executor
     *
     * @return Order
     */
    public function setExecutor(\AppBundle\Entity\User $executor = null)
    {
        $this->executor = $executor;

        return $this;
    }

    /**
     * Get executor
     *
     * @return \AppBundle\Entity\User
     */
    public function getExecutor()
    {
        return $this->executor;
    }

    /**
     * Add message
     *
     * @param \AppBundle\Entity\Message $message
     *
     * @return Order
     */
    public function addMessage(\AppBundle\Entity\Message $message)
    {
        $this->messages[] = $message;

        return $this;
    }

    /**
     * Remove message
     *
     * @param \AppBundle\Entity\Message $message
     */
    public function removeMessage(\AppBundle\Entity\Message $message)
    {
        $this->messages->removeElement($message);
    }

    /**
     * Get messages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Order
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Order
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set zip
     *
     * @param string $zip
     *
     * @return Order
     */
    public function setZip($zip)
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * Get zip
     *
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Set street
     *
     * @param string $street
     *
     * @return Order
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set building
     *
     * @param string $building
     *
     * @return Order
     */
    public function setBuilding($building)
    {
        $this->building = $building;

        return $this;
    }

    /**
     * Get building
     *
     * @return string
     */
    public function getBuilding()
    {
        return $this->building;
    }

    /**
     * Set apartment
     *
     * @param string $apartment
     *
     * @return Order
     */
    public function setApartment($apartment)
    {
        $this->apartment = $apartment;

        return $this;
    }

    /**
     * Get apartment
     *
     * @return string
     */
    public function getApartment()
    {
        return $this->apartment;
    }

    /**
     * Set deliveryType
     *
     * @param \AppBundle\Entity\Delivery $deliveryType
     *
     * @return Order
     */
    public function setDeliveryType(\AppBundle\Entity\Delivery $deliveryType = null)
    {
        $this->deliveryType = $deliveryType;

        return $this;
    }

    /**
     * Get deliveryType
     *
     * @return \AppBundle\Entity\Delivery
     */
    public function getDeliveryType()
    {
        return $this->deliveryType;
    }

    /**
     * Set review
     *
     * @param \AppBundle\Entity\Review $review
     *
     * @return Order
     */
    public function setReview(\AppBundle\Entity\Review $review = null)
    {
        $this->review = $review;

        return $this;
    }

    /**
     * Get review
     *
     * @return \AppBundle\Entity\Review
     */
    public function getReview()
    {
        return $this->review;
    }
}
