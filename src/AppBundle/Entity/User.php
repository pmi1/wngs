<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Embed\PreviewEmbed;
use AppBundle\Entity\Field\OrderingField;
use AppBundle\Entity\Field\Datetime\CreatedAtField;
use AppBundle\Entity\Field\Datetime\UpdatedAtField;
use AppBundle\Entity\Field\Preview\PreviewField;
use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User.
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\UserRepository")
 * @UniqueEntity(fields="login", message="Email already taken")
 */
class User extends AbstractEntity implements AdvancedUserInterface, \Serializable
{
    use OrderingField;
    use PreviewField;
    use UpdatedAtField;
    use CreatedAtField;
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=255, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $login;

    /**
     * @var Media
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media",cascade={"persist"})
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="image", referencedColumnName="id")
     * })
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="text", options={"default" : ""}, nullable=true)
     */
    private $password;
    
    /**
     * @var string
     *
     * @ORM\Column(name="plain_password", type="string", length=255, options={"default" : ""}, nullable=true)
     */
    private $plainPassword;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="brand", type="string", length=255, nullable=true)
     */
    private $brand;

    /**
     * @var Media
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media",cascade={"persist"})
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="brand_image", referencedColumnName="id")
     * })
     */
    private $brandImage;

    /**
     * @var string
     *
     * @ORM\Column(name="text_type", type="text", nullable=true)
     */
    private $textType;

    /**
     * @var string
     *
     * @ORM\Column(name="text_raw", type="text", nullable=true)
     */
    private $textRaw;

    /**
     * @var string
     *
     * @ORM\Column(name="text_formatted", type="text", nullable=true)
     */
    private $textFormatted;

    /**
     * @var string
     *
     * @ORM\Column(name="promo_type", type="text", nullable=true)
     */
    private $promoType;

    /**
     * @var string
     *
     * @ORM\Column(name="promo_raw", type="text", nullable=true)
     */
    private $promoRaw;

    /**
     * @var string
     *
     * @ORM\Column(name="promo_formatted", type="text", nullable=true)
     */
    private $promoFormatted;

    /**
     * @var string
     *
     * @ORM\Column(name="delivery_type", type="text", nullable=true)
     */
    private $deliveryType;

    /**
     * @var string
     *
     * @ORM\Column(name="delivery_raw", type="text", nullable=true)
     */
    private $deliveryRaw;

    /**
     * @var string
     *
     * @ORM\Column(name="delivery_formatted", type="text", nullable=true)
     */
    private $deliveryFormatted;

    /**
     * @var string
     *
     * @ORM\Column(name="payment_type", type="text", nullable=true)
     */
    private $paymentType;

    /**
     * @var string
     *
     * @ORM\Column(name="payment_raw", type="text", nullable=true)
     */
    private $paymentRaw;

    /**
     * @var string
     *
     * @ORM\Column(name="payment_formatted", type="text", nullable=true)
     */
    private $paymentFormatted;

    /**
     * @var string
     *
     * @ORM\Column(name="condition_type", type="text", nullable=true)
     */
    private $conditionType;

    /**
     * @var string
     *
     * @ORM\Column(name="condition_raw", type="text", nullable=true)
     */
    private $conditionRaw;

    /**
     * @var string
     *
     * @ORM\Column(name="condition_formatted", type="text", nullable=true)
     */
    private $conditionFormatted;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook", type="string", length=255, nullable=true)
     */
    private $facebook;

    /**
     * @var string
     *
     * @ORM\Column(name="instagram", type="string", length=255, nullable=true)
     */
    private $instagram;

    /**
     * @var string
     *
     * @ORM\Column(name="twitter", type="string", length=255, nullable=true)
     */
    private $twitter;

    /**
     * @var string
     *
     * @ORM\Column(name="behance", type="string", length=255, nullable=true)
     */
    private $behance;

    /**
     * @var string
     *
     * @ORM\Column(name="vk", type="string", length=255, nullable=true)
     */
    private $vk;

    /**
     * @var string
     *
     * @ORM\Column(name="site", type="string", length=255, nullable=true)
     */
    private $site;

    /**
     * @var bool
     *
     * @ORM\Column(name="status", type="boolean", options={"default" = false})
     */
    private $status;

    /**
     * @var bool
     *
     * @ORM\Column(name="designer", type="boolean", nullable=true, options={"default" = false})
     */
    private $designer;


    /**
     * @var bool
     *
     * @ORM\Column(name="active_catalogue", type="boolean", nullable=true, options={"default" = false})
     */
    private $activeCatalogue;

    /**
     * @var bool
     *
     * @ORM\Column(name="on_main", type="boolean", nullable=true, options={"default" = false})
     */
    private $onMain;

    /**
     * @var \DateTime $birthDate Дата рождения
     *
     * @ORM\Column(name="birthDate", type="date", nullable=true)
     */
    private $birthDate;

    /**
     * @var ArrayCollection|RoleGroup[]
     *
     * @ORM\ManyToMany(targetEntity="RoleGroup")
     * @ORM\JoinTable(name="user_role_group",
     *   joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="roles_group_id", referencedColumnName="id")}
     * )
     */
    private $roleGroups;
    

    /**
     * @ORM\OneToMany(targetEntity="Article", mappedBy="user")
     */
    protected $articles;

    /**
     * @ORM\OneToMany(targetEntity="Item", mappedBy="user")
     */
    protected $items;

    /**
     * @ORM\OneToMany(targetEntity="Selection", mappedBy="user")
     */
    protected $selections;


    /**
     * @var ArrayCollection|FormAnswer[]
     *
     * @ORM\OneToMany(targetEntity="FormAnswer", mappedBy="user", cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */

    protected $requests;

    /**
     * @var ArrayCollection|Order[]
     *
     * @ORM\OneToMany(targetEntity="Order", mappedBy="user", cascade={"persist"})
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */

    protected $orders;

    /**
     * @var ArrayCollection|Order[]
     *
     * @ORM\OneToMany(targetEntity="Order", mappedBy="executor", cascade={"persist"})
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */

    protected $brandOrders;

    /**
     * @var ArrayCollection|UserFavorite[]
     *
     * @ORM\OneToMany(targetEntity="UserFavorite", mappedBy="user", cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC"})
     * @Assert\Valid
     */

    protected $favorites;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_title", type="string", length=255, nullable=true)
     */
    private $metaTitle;
    
    /**
     * @var string
     *
     * @ORM\Column(name="meta_description", type="text", nullable=true)
     */
    private $metaDescription;
    
    /**
     * @var string
     *
     * @ORM\Column(name="meta_keywords", type="text", nullable=true)
     */
    private $metaKeywords;

    /**
     * @var UserType
     *
     * @ORM\ManyToOne(targetEntity="UserType")
     * @ORM\JoinColumn(name="user_type_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $userType;

    /**
     * @ORM\Column(name="oauth_type", type="string", length=255, nullable=true)
     */
    protected $oauthType;

    /**
     * @ORM\Column(name="oauth_id", type="string", length=255, nullable=true)
     */
    protected $oauthId;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->roleGroups = new ArrayCollection();
        $this->status = false;
        $this->designer = false;
        $this->activeCatalogue = false;
        $this->preview = new PreviewEmbed();
        $this->favorites = new ArrayCollection();
        $this->requests = new ArrayCollection();
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
     * Get userId.
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return User
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
     * Set plain password.
     *
     * @param string $plainPassword
     *
     * @return User
     */
    public function setPlainPassword($plainPassword)
    {
        if ($plainPassword) {
            $this->plainPassword = $plainPassword;
        }
        
        return $this;
    }

    /**
     * Get plain password.
     *
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Set password.
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        if ($password) {
            $this->password = $password;
        }
        
        $this->plainPassword = '';
        
        return $this;
    }

    /**
     * Get password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set status.
     *
     * @param bool $status
     *
     * @return User
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
     * Get roles.
     *
     * @return array
     */
    public function getRoles()
    {
        $roles = $this->buildUserRoles();

        return $roles;
    }

    /**
     * Add roleGroup.
     *
     * @param RoleGroup $roleGroup
     *
     * @return User
     */
    public function addRoleGroup(RoleGroup $roleGroup)
    {
        $this->roleGroups[] = $roleGroup;

        return $this;
    }

    /**
     * Remove roleGroup.
     *
     * @param RoleGroup $roleGroup
     *
     * @return User
     */
    public function removeRoleGroup(RoleGroup $roleGroup)
    {
        $this->roleGroups->removeElement($roleGroup);

        return $this;
    }

    /**
     * Get roleGroups.
     *
     * @return ArrayCollection
     */
    public function getRoleGroups()
    {
        return $this->roleGroups;
    }

    /**
     * Set login.
     *
     * @param string $login
     *
     * @return User
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login.
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->login;
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt()
    {
        return null;
    }
    
    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
    }
    
    /**
     * {@inheritdoc}
     */
    public function isAccountNonExpired()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isAccountNonLocked()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isEnabled()
    {
        return $this->status;
    }
    
    /**
     * Сериализация основных пользовательских данных
     *
     * @return string
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->login,
            $this->password,
            $this->status
        ));
    }
    
    /**
     * Десериализация основных пользовательских данных
     *
     * @param string $serialized
     *
     * @return array
     */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->login,
            $this->password,
            $this->status
        ) = unserialize($serialized);
    }
     
    /**
     * Получить идентификаторы групп ролей пользователя
     *
     * @return array
     */
    public function getRoleGroupIds()
    {
        $userRoles = [];
        
        $roleGroups = $this->roleGroups;
        
        foreach ($roleGroups as $role) {
            $userRoles[] = $role->getId();
        }
        
        sort($userRoles);
        
        return $userRoles;
    }
    
    /**
     * Сформировать алиасы групп ролей пользователя
     *
     * @return array
     */
    public function buildUserRoles()
    {
        $userRoles = [];
        
        $roleGroups = $this->getRoleGroupIds();
        
        foreach ($roleGroups as $roleId) {
            $userRoles[] = 'ROLE_'.$roleId;
        }
        
        return $userRoles;
    }
    
    /**
     * Сформировать хэш групп ролей пользователя
     *
     * @return string
     */
    public function getRGHash()
    {
        $roles = $this->getRoles();
        
        return md5(implode("-", $roles));
    }
    
    /*
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }
    */

    /**
     * Set image
     *
     * @param Media $image
     *
     * @return User
     */
    public function setImage(Media $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return Media
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return User
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
     * Set brand
     *
     * @param string $brand
     *
     * @return User
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set textType
     *
     * @param string $textType
     *
     * @return User
     */
    public function setTextType($textType)
    {
        $this->textType = $textType;

        return $this;
    }

    /**
     * Get textType
     *
     * @return string
     */
    public function getTextType()
    {
        return $this->textType;
    }

    /**
     * Set textRaw
     *
     * @param string $textRaw
     *
     * @return User
     */
    public function setTextRaw($textRaw)
    {
        $this->textRaw = $textRaw;

        return $this;
    }

    /**
     * Get textRaw
     *
     * @return string
     */
    public function getTextRaw()
    {
        return $this->textRaw;
    }

    /**
     * Set textFormatted
     *
     * @param string $textFormatted
     *
     * @return User
     */
    public function setTextFormatted($textFormatted)
    {
        $this->textFormatted = $textFormatted;

        return $this;
    }

    /**
     * Get textFormatted
     *
     * @return string
     */
    public function getTextFormatted()
    {
        return $this->textFormatted;
    }

    /**
     * Set deliveryType
     *
     * @param string $deliveryType
     *
     * @return User
     */
    public function setDeliveryType($deliveryType)
    {
        $this->deliveryType = $deliveryType;

        return $this;
    }

    /**
     * Get deliveryType
     *
     * @return string
     */
    public function getDeliveryType()
    {
        return $this->deliveryType;
    }

    /**
     * Set deliveryRaw
     *
     * @param string $deliveryRaw
     *
     * @return User
     */
    public function setDeliveryRaw($deliveryRaw)
    {
        $this->deliveryRaw = $deliveryRaw;

        return $this;
    }

    /**
     * Get deliveryRaw
     *
     * @return string
     */
    public function getDeliveryRaw()
    {
        return $this->deliveryRaw;
    }

    /**
     * Set deliveryFormatted
     *
     * @param string $deliveryFormatted
     *
     * @return User
     */
    public function setDeliveryFormatted($deliveryFormatted)
    {
        $this->deliveryFormatted = $deliveryFormatted;

        return $this;
    }

    /**
     * Get deliveryFormatted
     *
     * @return string
     */
    public function getDeliveryFormatted()
    {
        return $this->deliveryFormatted;
    }

    /**
     * Set paymentType
     *
     * @param string $paymentType
     *
     * @return User
     */
    public function setPaymentType($paymentType)
    {
        $this->paymentType = $paymentType;

        return $this;
    }

    /**
     * Get paymentType
     *
     * @return string
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }

    /**
     * Set paymentRaw
     *
     * @param string $paymentRaw
     *
     * @return User
     */
    public function setPaymentRaw($paymentRaw)
    {
        $this->paymentRaw = $paymentRaw;

        return $this;
    }

    /**
     * Get paymentRaw
     *
     * @return string
     */
    public function getPaymentRaw()
    {
        return $this->paymentRaw;
    }

    /**
     * Set paymentFormatted
     *
     * @param string $paymentFormatted
     *
     * @return User
     */
    public function setPaymentFormatted($paymentFormatted)
    {
        $this->paymentFormatted = $paymentFormatted;

        return $this;
    }

    /**
     * Get paymentFormatted
     *
     * @return string
     */
    public function getPaymentFormatted()
    {
        return $this->paymentFormatted;
    }

    /**
     * Set facebook
     *
     * @param string $facebook
     *
     * @return User
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Get facebook
     *
     * @return string
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Set instagram
     *
     * @param string $instagram
     *
     * @return User
     */
    public function setInstagram($instagram)
    {
        $this->instagram = $instagram;

        return $this;
    }

    /**
     * Get instagram
     *
     * @return string
     */
    public function getInstagram()
    {
        return $this->instagram;
    }

    /**
     * Set twitter
     *
     * @param string $twitter
     *
     * @return User
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * Get twitter
     *
     * @return string
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * Set behance
     *
     * @param string $behance
     *
     * @return User
     */
    public function setBehance($behance)
    {
        $this->behance = $behance;

        return $this;
    }

    /**
     * Get behance
     *
     * @return string
     */
    public function getBehance()
    {
        return $this->behance;
    }

    /**
     * Set vk
     *
     * @param string $vk
     *
     * @return User
     */
    public function setVk($vk)
    {
        $this->vk = $vk;

        return $this;
    }

    /**
     * Get vk
     *
     * @return string
     */
    public function getVk()
    {
        return $this->vk;
    }

    /**
     * Set brandImage
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $brandImage
     *
     * @return User
     */
    public function setBrandImage(\Application\Sonata\MediaBundle\Entity\Media $brandImage = null)
    {
        $this->brandImage = $brandImage;

        return $this;
    }

    /**
     * Get brandImage
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media
     */
    public function getBrandImage()
    {
        return $this->brandImage;
    }

    /**
     * Add article
     *
     * @param \AppBundle\Entity\Article $article
     *
     * @return User
     */
    public function addArticle(\AppBundle\Entity\Article $article)
    {
        $this->articles[] = $article;

        return $this;
    }

    /**
     * Remove article
     *
     * @param \AppBundle\Entity\Article $article
     */
    public function removeArticle(\AppBundle\Entity\Article $article)
    {
        $this->articles->removeElement($article);
    }

    /**
     * Get articles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * Add item
     *
     * @param \AppBundle\Entity\Item $item
     *
     * @return User
     */
    public function addItem(\AppBundle\Entity\Item $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * Remove item
     *
     * @param \AppBundle\Entity\Item $item
     */
    public function removeItem(\AppBundle\Entity\Item $item)
    {
        $this->items->removeElement($item);
    }

    /**
     * Get items
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Add selection
     *
     * @param \AppBundle\Entity\Selection $selection
     *
     * @return User
     */
    public function addSelection(\AppBundle\Entity\Selection $selection)
    {
        $this->selections[] = $selection;

        return $this;
    }

    /**
     * Remove selection
     *
     * @param \AppBundle\Entity\Selection $selection
     */
    public function removeSelection(\AppBundle\Entity\Selection $selection)
    {
        $this->selections->removeElement($selection);
    }

    /**
     * Get selections
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSelections()
    {
        return $this->selections;
    }

    /**
     * Set conditionType
     *
     * @param string $conditionType
     *
     * @return User
     */
    public function setConditionType($conditionType)
    {
        $this->conditionType = $conditionType;

        return $this;
    }

    /**
     * Get conditionType
     *
     * @return string
     */
    public function getConditionType()
    {
        return $this->conditionType;
    }

    /**
     * Set conditionRaw
     *
     * @param string $conditionRaw
     *
     * @return User
     */
    public function setConditionRaw($conditionRaw)
    {
        $this->conditionRaw = $conditionRaw;

        return $this;
    }

    /**
     * Get conditionRaw
     *
     * @return string
     */
    public function getConditionRaw()
    {
        return $this->conditionRaw;
    }

    /**
     * Set conditionFormatted
     *
     * @param string $conditionFormatted
     *
     * @return User
     */
    public function setConditionFormatted($conditionFormatted)
    {
        $this->conditionFormatted = $conditionFormatted;

        return $this;
    }

    /**
     * Get conditionFormatted
     *
     * @return string
     */
    public function getConditionFormatted()
    {
        return $this->conditionFormatted;
    }

    /**
     * Set designer
     *
     * @param boolean $designer
     *
     * @return User
     */
    public function setDesigner($designer)
    {
        $this->designer = $designer;

        return $this;
    }

    /**
     * Get designer
     *
     * @return boolean
     */
    public function getDesigner()
    {
        return $this->designer;
    }

    /**
     * Set promoType
     *
     * @param string $promoType
     *
     * @return User
     */
    public function setPromoType($promoType)
    {
        $this->promoType = $promoType;

        return $this;
    }

    /**
     * Get promoType
     *
     * @return string
     */
    public function getPromoType()
    {
        return $this->promoType;
    }

    /**
     * Set promoRaw
     *
     * @param string $promoRaw
     *
     * @return User
     */
    public function setPromoRaw($promoRaw)
    {
        $this->promoRaw = $promoRaw;

        return $this;
    }

    /**
     * Get promoRaw
     *
     * @return string
     */
    public function getPromoRaw()
    {
        return $this->promoRaw;
    }

    /**
     * Set promoFormatted
     *
     * @param string $promoFormatted
     *
     * @return User
     */
    public function setPromoFormatted($promoFormatted)
    {
        $this->promoFormatted = $promoFormatted;

        return $this;
    }

    /**
     * Get promoFormatted
     *
     * @return string
     */
    public function getPromoFormatted()
    {
        return $this->promoFormatted;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return User
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
     * Set city
     *
     * @param string $city
     *
     * @return User
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
     * Set metaTitle
     *
     * @param string $metaTitle
     *
     * @return User
     */
    public function setMetaTitle($metaTitle)
    {
        $this->metaTitle = $metaTitle;

        return $this;
    }

    /**
     * Get metaTitle
     *
     * @return string
     */
    public function getMetaTitle()
    {
        return $this->metaTitle;
    }

    /**
     * Set metaDescription
     *
     * @param string $metaDescription
     *
     * @return User
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    /**
     * Get metaDescription
     *
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * Set metaKeywords
     *
     * @param string $metaKeywords
     *
     * @return User
     */
    public function setMetaKeywords($metaKeywords)
    {
        $this->metaKeywords = $metaKeywords;

        return $this;
    }

    /**
     * Get metaKeywords
     *
     * @return string
     */
    public function getMetaKeywords()
    {
        return $this->metaKeywords;
    }

    /**
     * Set userType
     *
     * @param \AppBundle\Entity\UserType $userType
     *
     * @return User
     */
    public function setUserType(\AppBundle\Entity\UserType $userType = null)
    {
        $this->userType = $userType;

        return $this;
    }

    /**
     * Get userType
     *
     * @return \AppBundle\Entity\UserType
     */
    public function getUserType()
    {
        return $this->userType;
    }

    /**
     * Add favorite
     *
     * @param \AppBundle\Entity\UserFavorite $favorite
     *
     * @return User
     */
    public function addFavorite(\AppBundle\Entity\UserFavorite $favorite)
    {
        $favorite->setUser($this);
        $this->favorites[] = $favorite;

        return $this;
    }

    /**
     * Remove favorite
     *
     * @param \AppBundle\Entity\UserFavorite $favorite
     */
    public function removeFavorite(\AppBundle\Entity\UserFavorite $favorite)
    {
        $this->favorites->removeElement($favorite);
    }

    /**
     * Get favorites
     *
     * @return Collection | UserFavorite[]
     */
    public function getFavorites()
    {
        return $this->favorites;
    }

    /**
     * Set onMain
     *
     * @param boolean $onMain
     *
     * @return User
     */
    public function setOnMain($onMain)
    {
        $this->onMain = $onMain;

        return $this;
    }

    /**
     * Get onMain
     *
     * @return boolean
     */
    public function getOnMain()
    {
        return $this->onMain;
    }

    /**
     * Set site
     *
     * @param string $site
     *
     * @return User
     */
    public function setSite($site)
    {
        $this->site = $site;

        return $this;
    }

    /**
     * Get site
     *
     * @return string
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Set oauthType
     *
     * @param string $oauthType
     *
     * @return User
     */
    public function setOauthType($oauthType)
    {
        $this->oauthType = $oauthType;

        return $this;
    }

    /**
     * Get oauthType
     *
     * @return string
     */
    public function getOauthType()
    {
        return $this->oauthType;
    }

    /**
     * Set oauthId
     *
     * @param string $oauthId
     *
     * @return User
     */
    public function setOauthId($oauthId)
    {
        $this->oauthId = $oauthId;

        return $this;
    }

    /**
     * Get oauthId
     *
     * @return string
     */
    public function getOauthId()
    {
        return $this->oauthId;
    }

    /**
     * Set birthDate
     *
     * @param \DateTime $birthDate
     *
     * @return User
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Add request
     *
     * @param \AppBundle\Entity\FormAnswer $request
     *
     * @return User
     */
    public function addRequest(\AppBundle\Entity\FormAnswer $request)
    {
        $this->requests[] = $request;

        return $this;
    }

    /**
     * Remove request
     *
     * @param \AppBundle\Entity\FormAnswer $request
     */
    public function removeRequest(\AppBundle\Entity\FormAnswer $request)
    {
        $this->requests->removeElement($request);
    }

    /**
     * Get requests
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRequests()
    {
        return $this->requests;
    }

    /**
     * Set activeCatalogue
     *
     * @param boolean $activeCatalogue
     *
     * @return User
     */
    public function setActiveCatalogue($activeCatalogue)
    {
        $this->activeCatalogue = $activeCatalogue;

        return $this;
    }

    /**
     * Get activeCatalogue
     *
     * @return boolean
     */
    public function getActiveCatalogue()
    {
        return $this->activeCatalogue;
    }

    /**
     * Add order
     *
     * @param \AppBundle\Entity\Order $order
     *
     * @return User
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

    /**
     * Add brandOrder
     *
     * @param \AppBundle\Entity\Order $brandOrder
     *
     * @return User
     */
    public function addBrandOrder(\AppBundle\Entity\Order $brandOrder)
    {
        $this->brandOrders[] = $brandOrder;

        return $this;
    }

    /**
     * Remove brandOrder
     *
     * @param \AppBundle\Entity\Order $brandOrder
     */
    public function removeBrandOrder(\AppBundle\Entity\Order $brandOrder)
    {
        $this->brandOrders->removeElement($brandOrder);
    }

    /**
     * Get brandOrders
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBrandOrders()
    {
        return $this->brandOrders;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->designer ? $this->brand : '';
    }

    /**
     * Get brand
     *
     * @return string
     */
    public function getCatalogueItems()
    {
        return $this->brand;
    }
}
