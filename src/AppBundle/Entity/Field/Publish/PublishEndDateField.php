<?php

namespace AppBundle\Entity\Field\Publish;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 */
trait PublishEndDateField
{
    /**
     * @var \Datetime|null
     *
     * @ORM\Column(name="publish_end_date", type="datetime", nullable=true)
     */
    private $publishEndDate;

    /**
     * @return \Datetime|null
     */
    public function getPublishEndDate()
    {
        return $this->publishEndDate;
    }

    /**
     * @param \Datetime|null $publishEndDate
     *
     * @return PublishEndDateField
     */
    public function setPublishEndDate(\Datetime $publishEndDate = null): self
    {
        $this->publishEndDate = $publishEndDate;

        return $this;
    }
}
