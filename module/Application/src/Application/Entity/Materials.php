<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Materials
 *
 * @ORM\Table(name="Materials")
 * @ORM\Entity
 */
class Materials
{
    /**
     * @var string
     *
     * @ORM\Column(name="MaterialName", type="string", length=64, nullable=false)
     */
    private $MaterialName;

    /**
     * @var integer
     *
     * @ORM\Column(name="MaterialId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $MaterialId;


    /**
     * Set MaterialName
     *
     * @param string $materialName
     * @return Materials
     */
    public function setMaterialName($materialName)
    {
        $this->MaterialName = $materialName;

        return $this;
    }

    /**
     * Get MaterialName
     *
     * @return string 
     */
    public function getMaterialName()
    {
        return $this->MaterialName;
    }

    /**
     * Get MaterialId
     *
     * @return integer 
     */
    public function getMaterialId()
    {
        return $this->MaterialId;
    }

    // alias functions

    public function getId() {
        return $this->getMaterialId();
    }

    public function getName() {
        return $this->getMaterialName();
    }
}
