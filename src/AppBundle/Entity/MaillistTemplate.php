<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Embed\TextEmbed;
use AppBundle\Entity\Field\NameField;
use AppBundle\Entity\Field\Text\TextField;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Шаблоны почтовых уведолмений
 *
 * @ORM\Table(name="maillist_template")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\MaillistTemplateRepository")
 */
class MaillistTemplate extends AbstractEntity
{
    use NameField;
    use TextField;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=255, nullable=true)
     */
    private $subject;

    /**
     * @var string
     *
     * @ORM\Column(name="from_name", type="string", length=255, nullable=true)
     */
    private $fromName;

    /**
     * @var string
     *
     * @ORM\Column(name="from_email", type="string", length=255, nullable=true)
     */
    private $fromEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="to_name", type="string", length=255, nullable=true)
     */
    private $toName;

    /**
     * @var string
     *
     * @ORM\Column(name="to_email", type="string", length=255, nullable=true)
     */
    private $toEmail;

    /**
     * MaillistTemplate constructor.
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
     * Set subject
     *
     * @param string $subject
     *
     * @return MaillistTemplate
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set fromName
     *
     * @param string $fromName
     *
     * @return MaillistTemplate
     */
    public function setFromName($fromName)
    {
        $this->fromName = $fromName;

        return $this;
    }

    /**
     * Get fromName
     *
     * @return string
     */
    public function getFromName()
    {
        return $this->fromName;
    }

    /**
     * Set fromEmail
     *
     * @param string $fromEmail
     *
     * @return MaillistTemplate
     */
    public function setFromEmail($fromEmail)
    {
        $this->fromEmail = $fromEmail;

        return $this;
    }

    /**
     * Get fromEmail
     *
     * @return string
     */
    public function getFromEmail()
    {
        return $this->fromEmail;
    }

    /**
     * Set toName
     *
     * @param string $toName
     *
     * @return MaillistTemplate
     */
    public function setToName($toName)
    {
        $this->toName = $toName;

        return $this;
    }

    /**
     * Get toName
     *
     * @return string
     */
    public function getToName()
    {
        return $this->toName;
    }

    /**
     * Set toEmail
     *
     * @param string $toEmail
     *
     * @return MaillistTemplate
     */
    public function setToEmail($toEmail)
    {
        $this->toEmail = $toEmail;

        return $this;
    }

    /**
     * Get toEmail
     *
     * @return string
     */
    public function getToEmail()
    {
        return $this->toEmail;
    }
}
