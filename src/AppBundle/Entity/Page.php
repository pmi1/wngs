<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Embed\TextEmbed;
use AppBundle\Entity\Field\Datetime\CreatedAtField;
use AppBundle\Entity\Field\Datetime\DeletedAtField;
use AppBundle\Entity\Field\Datetime\UpdatedAtField;
use AppBundle\Entity\Field\LinkField;
use AppBundle\Entity\Field\NameField;
use AppBundle\Entity\Field\StatusField;
use AppBundle\Entity\Field\ImageField;
use AppBundle\Entity\Field\OrderingField;
use AppBundle\Entity\Field\Text\TextField;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Статичный контент
 *
 * @ORM\Table(name="page")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\PageRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Page extends AbstractEntity
{
    use NameField;
    use ImageField;
    use LinkField;
    use TextField;
    use OrderingField;
    use StatusField;
    use DeletedAtField;
    use UpdatedAtField;
    use CreatedAtField;


    /**
     * @var bool Открывать в новом окне?
     *
     * @ORM\Column(name="is_new_win", type="boolean", nullable=true, options={"default" = false})
     */
    private $isNewWin;

    /**
     * @var BannerPlace
     *
     * @ORM\ManyToOne(targetEntity="BannerPlace", inversedBy="pages")
     * @ORM\JoinColumn(name="banner_place_id", referencedColumnName="id")
     */
    private $bannerPlace;

    /**
     * Page constructor.
     */
    public function __construct()
    {
        $this->text = new TextEmbed();
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
     * Set bannerPlace
     *
     * @param \AppBundle\Entity\BannerPlace $bannerPlace
     *
     * @return Page
     */
    public function setBannerPlace(\AppBundle\Entity\BannerPlace $bannerPlace = null)
    {
        $this->bannerPlace = $bannerPlace;

        return $this;
    }

    /**
     * Get bannerPlace
     *
     * @return \AppBundle\Entity\BannerPlace
     */
    public function getBannerPlace()
    {
        return $this->bannerPlace;
    }

    /**
     * Set isNewWin
     *
     * @param boolean $isNewWin
     *
     * @return Page
     */
    public function setIsNewWin($isNewWin)
    {
        $this->isNewWin = $isNewWin;

        return $this;
    }

    /**
     * Get isNewWin
     *
     * @return boolean
     */
    public function getIsNewWin()
    {
        return $this->isNewWin;
    }
}
