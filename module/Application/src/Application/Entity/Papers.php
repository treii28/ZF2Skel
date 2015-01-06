<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Papers
 *
 * @ORM\Table(name="Papers")
 * @ORM\Entity
 */
class Papers
{
    /**
     * @var string
     *
     * @ORM\Column(name="PaperName", type="string", length=64, nullable=false)
     */
    private $PaperName;

    /**
     * @var integer
     *
     * @ORM\Column(name="PaperId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $PaperId;


    /**
     * Set PaperName
     *
     * @param string $paperName
     * @return Papers
     */
    public function setPaperName($paperName)
    {
        $this->PaperName = $paperName;

        return $this;
    }

    /**
     * Get PaperName
     *
     * @return string 
     */
    public function getPaperName()
    {
        return $this->PaperName;
    }

    /**
     * Get PaperId
     *
     * @return integer 
     */
    public function getPaperId()
    {
        return $this->PaperId;
    }

    // alias functions

    public function getId() {
        return $this->getPaperId();
    }

    public function getName() {
        return $this->getPaperName();
    }
}
