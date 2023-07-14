<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Item;
use AppBundle\Entity\User;
use AppBundle\Entity\Field\Datetime\DeletedAtField;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * UserFavorite
 *
 * @ORM\Table(name="user_favorite")
 * @UniqueEntity(fields={"user", "item"})
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\UserFavoriteRepository")
 *
 * Избранное пользователя
 */
class UserFavorite extends AbstractEntity
{
    /**
     * @var Item
     *
     * @ORM\ManyToOne(targetEntity="Item", inversedBy="favorites")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id")
     */
    private $item;
    
    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="favorites")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;


    /**
     * Get name as string
     *
      * @return string
     */
    public function __toString()
    {
        return '1';
    }

    /**
     * Set item
     *
     * @param Item $item
     *
     * @return UserFavorite
     */
    public function setItem(Item $item = null)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get item
     *
     * @return Item
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return UserFavorite
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
