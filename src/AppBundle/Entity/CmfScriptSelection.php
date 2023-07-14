<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\CmfScript;
use AppBundle\Entity\Selection;

/**
 * CmfScriptSelection
 *
 * @ORM\Table(name="cmf_script_selection")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\CmfScriptSelectionRepository")
 *
 * Связь страницы с выборками
 */
class CmfScriptSelection extends AbstractEntity
{
    /**
     * @var CmfScript
     *
     * @ORM\ManyToOne(targetEntity="CmfScript", inversedBy="cmfScriptSelections")
     * @ORM\JoinColumn(name="cmf_script_id", referencedColumnName="id")
     */
    private $cmfScript;
    
    /**
     * @var Selection
     *
     * @ORM\ManyToOne(targetEntity="Selection", inversedBy="cmfScriptSelections")
     * @ORM\JoinColumn(name="selection_id", referencedColumnName="id")
     */
    private $selection;

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
     * Set cmfScript
     *
     * @param CmfScript $cmfScript
     *
     * @return CmfScriptSelection
     */
    public function setCmfScript(CmfScript $cmfScript = null)
    {
        $this->cmfScript = $cmfScript;

        return $this;
    }

    /**
     * Get cmfScript
     *
     * @return CmfScript
     */
    public function getCmfScript()
    {
        return $this->cmfScript;
    }

    /**
     * Set selection
     *
     * @param \AppBundle\Entity\Selection $selection
     *
     * @return CmfScriptSelection
     */
    public function setSelection(\AppBundle\Entity\Selection $selection = null)
    {
        $this->selection = $selection;

        return $this;
    }

    /**
     * Get selection
     *
     * @return \AppBundle\Entity\Selection
     */
    public function getSelection()
    {
        return $this->selection;
    }
}
