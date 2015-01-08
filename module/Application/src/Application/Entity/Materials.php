<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Materials
 *
 * @ORM\Entity
 * @ORM\Table(name="Materials")
 */
class Materials extends ListItems
{
    /**
     * @var string $MaterialName
     *
     * @ORM\Column(name="MaterialName", type="string", length=64, nullable=false)
     */
    protected $MaterialName;

    /**
     * @return int
     */
    public function getMaterialId() {
        return $this->getMemberId();
    }

    /**
     * @param integer $materialId
     * @return ListXref
     */
    public function setMaterialId($materialId) {
        return $this->setMemberId($materialId);
    }

    public function __construct() {
        parent::__construct();
        $this->setEntityName(__CLASS__);
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
