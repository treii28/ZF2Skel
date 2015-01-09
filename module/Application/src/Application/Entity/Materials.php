<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Materials
 *
 * @ORM\Entity
 * @ORM\Table(name="Materials", uniqueConstraints={
 *      @ORM\UniqueConstraint(name="UniqueMaterialId_idx", columns={"MaterialId"}),
 *      @ORM\UniqueConstraint(name="UniqueMaterialName_idx", columns={"MaterialName"})
 *   }
 * )
 */
class Materials extends ListItems
{
    /**
     * legacy unique identifier
     *
     * @var integer
     *
     * @ORM\Column(name="MaterialId", type="integer", nullable=true)
     */
    protected $MaterialId;

    /**
     * @var string $MaterialName
     *
     * @ORM\Column(name="MaterialName", type="string", length=64, nullable=false)
     */
    protected $MaterialName;

    public function __construct() {
        parent::__construct();
        $this->setEntityName(__CLASS__);
    }

    /**
     * @return int
     */
    public function getMaterialId() {
        return $this->MaterialId;
    }

    /**
     * @param integer $materialId
     * @return ListItems
     */
    public function setMaterialId($materialId) {
        $this->MaterialId = $materialId;

        return $this;
    }

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

    public function getItemEntity() {
        return __CLASS__;
    }
}
