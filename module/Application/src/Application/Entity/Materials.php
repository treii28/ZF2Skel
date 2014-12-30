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
     * @ORM\Column(name="materialName", type="string", length=64, nullable=false)
     */
    private $materialName;

    /**
     * @var integer
     *
     * @ORM\Column(name="MaterialId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $materialId;


    /**
     * Set materialName
     *
     * @param string $materialName
     * @return Materials
     */
    public function setMaterialName($materialName)
    {
        $this->materialName = $materialName;

        return $this;
    }

    /**
     * Get materialName
     *
     * @return string 
     */
    public function getMaterialName()
    {
        return $this->materialName;
    }

    /**
     * Get materialId
     *
     * @return integer 
     */
    public function getMaterialId()
    {
        return $this->materialId;
    }
}
