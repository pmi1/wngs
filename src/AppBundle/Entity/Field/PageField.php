<?php

namespace AppBundle\Entity\Field;

use AppBundle\Entity\Page;
use Doctrine\ORM\Mapping as ORM;

/**
 * Трейт добавляет сущности поле со страницей
 *
 *
 */
trait PageField
{
    /**
     * @var Page|null Страница
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Page", cascade={"all"})
     * @ORM\JoinColumn(name="page_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $page;

    /**
     * @return Page|null
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param Page|null $page
     *
     * @return PageField
     */
    public function setPage(Page $page = null): self
    {
        $this->page = $page;

        return $this;
    }
}
