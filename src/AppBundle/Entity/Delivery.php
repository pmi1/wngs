<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\Field\NameField;
use AppBundle\Entity\Field\StatusField;
use AppBundle\Entity\Field\OrderingField;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Способы доставки
 *
 * @ORM\Table(name="delivery")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\DeliveryRepository")
 */
class Delivery extends AbstractEntity
{
    use NameField;
    use OrderingField;
    use StatusField;

    /**
     * @var ArrayCollection|Order[]
     *
     * @ORM\OneToMany(targetEntity="Order", mappedBy="deliveryType", cascade={"persist"})
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */

    protected $orders;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->orders = new ArrayCollection();
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
     * Add order
     *
     * @param \AppBundle\Entity\Order $order
     *
     * @return Delivery
     */
    public function addOrder(\AppBundle\Entity\Order $order)
    {
        $this->orders[] = $order;

        return $this;
    }

    /**
     * Remove order
     *
     * @param \AppBundle\Entity\Order $order
     */
    public function removeOrder(\AppBundle\Entity\Order $order)
    {
        $this->orders->removeElement($order);
    }

    /**
     * Get orders
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrders()
    {
        return $this->orders;
    }
}
