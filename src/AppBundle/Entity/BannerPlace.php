<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Field\Datetime\CreatedAtField;
use AppBundle\Entity\Field\Datetime\DeletedAtField;
use AppBundle\Entity\Field\Datetime\UpdatedAtField;
use AppBundle\Entity\Field\NameField;
use AppBundle\Entity\Field\StatusField;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Группы баннеров
 *
 * @ORM\Table(name="banner_place")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\BannerPlaceRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class BannerPlace extends AbstractEntity
{
    use NameField;
    use StatusField;
    use DeletedAtField;
    use UpdatedAtField;
    use CreatedAtField;

    /**
     * @var Pages
     *
     * @ORM\OneToMany(targetEntity="Page", mappedBy="bannerPlace", cascade={"persist"}, orphanRemoval=true)
     */
    private $pages;

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
     * Constructor
     */
    public function __construct()
    {
        $this->pages = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add page
     *
     * @param \AppBundle\Entity\Page $page
     *
     * @return BannerPlace
     */
    public function addPage(\AppBundle\Entity\Page $page)
    {
        $page->setBannerPlace($this);
        $this->pages[] = $page;

        return $this;
    }

    /**
     * Remove page
     *
     * @param \AppBundle\Entity\Page $page
     */
    public function removePage(\AppBundle\Entity\Page $page)
    {
        $this->pages->removeElement($page);
    }

    /**
     * Get pages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPages()
    {
        return $this->pages;
    }
}
