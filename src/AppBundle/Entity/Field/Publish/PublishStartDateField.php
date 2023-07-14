<?php

namespace AppBundle\Entity\Field\Publish;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 */
trait PublishStartDateField
{
    /**
     * @var \Datetime|null
     *
     * @ORM\Column(name="publish_start_date", type="datetime", nullable=true)
     */
    private $publishStartDate;

    /**
     * @return \Datetime|null
     */
    public function getPublishStartDate()
    {
        return $this->publishStartDate;
    }

    /**
     * @param \Datetime|null $publishStartDate
     *
     * @return PublishStartDateField
     */
    public function setPublishStartDate(\Datetime $publishStartDate = null): self
    {
        $this->publishStartDate = $publishStartDate;

        return $this;
    }
}
