<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Embed\TextEmbed;
use AppBundle\Entity\Field\Datetime\CreatedAtField;
use AppBundle\Entity\Field\Datetime\UpdatedAtField;
use AppBundle\Entity\Field\NameField;
use AppBundle\Entity\Field\StatusField;
use AppBundle\Entity\Field\Text\TextField;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Review
 *
 * @ORM\Table(name="review")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\ReviewRepository")
 *
 * Отзывы
 */
class Review extends AbstractEntity
{
    use NameField;
    use TextField;
    use StatusField;
    use UpdatedAtField;
    use CreatedAtField;


    /**
     * @var Order
     *
     * @ORM\OneToOne(targetEntity="Order", inversedBy="review")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     */
    private $order;

    /**
     * Page constructor.
     */
    public function __construct()
    {
        $this->text = new TextEmbed();
        $this->createdAt = new \DateTime('now');
    }


    /**
     * Get name as string
     
     * @return string
     */
    public function __toString()
    {
        return $this->id ? (string)$this->id : '';
    }

    /**
     * Set order
     *
     * @param \AppBundle\Entity\Order $order
     *
     * @return Review
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
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Review
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
}
