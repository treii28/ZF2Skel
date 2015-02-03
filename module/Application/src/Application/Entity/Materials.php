<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Materials
 *
 * @ORM\Entity
 * @ORM\Table(name="Materials", uniqueConstraints={
 *      @ORM\UniqueConstraint(name="UniqueMaterialNameId_idx", columns={"MaterialName","MaterialId"})
 *   }
 * )
 */
class Materials extends ListItems
{
    // <editor-fold desc="Entity properties bound to db columns">

    /**
     * legacy unique identifier
     *
     * @var integer
     *
     * @ORM\Column(name="MaterialId", type="integer",  options={"unsigned":true}, nullable=true)
     */
    protected $MaterialId;

    /**
     * Name for the given material
     *
     * @var string $MaterialName
     *
     * @ORM\Column(name="MaterialName", type="string", length=64, nullable=false)
     */
    protected $MaterialName;

    /**
     * Supplier name for the material
     *
     * @var string $SupplierName
     *
     * @ORM\Column(name="SupplierName", type="string", length=64, nullable=true)
     */
    protected $SupplierName;

    /**
     * @var string $PopUpMessage
     *
     * @ORM\Column(name="PopUpMessage", type="text", nullable=true)
     */
    protected $PopUpMessage;

    /**
     * @var array $valid_options
     * @static
     */
    protected static $valid_options = array('Indent Capable Materials','CutOut Capable Materials','Imprint Capable Materials','Etch Capable Materials','CoverImage Capable Materials','Leather Materials','Discontinued Materials');

    // </editor-fold desc="Entity properties bound to db columns">

    // <editor-fold desc="Core class functions">

    public function __construct() {
        parent::__construct();
        $this->setEntityName(__CLASS__);
    }

    // </editor-fold desc="Core class functions">

    // <editor-fold desc="Entity db properties accessors">

    /**
     * @param integer|null $materialId
     * @return ListItems
     */
    public function setMaterialId($materialId=null) {
        $this->MaterialId = $materialId;

        return $this;
    }

    /**
     * @return integer|null
     */
    public function getMaterialId() {
        return $this->MaterialId;
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

    /**
     * Set SupplierName
     *
     * @param string|null $supplierName
     * @return Materials
     */
    public function setSupplierName($supplierName=null)
    {
        $this->SupplierName = $supplierName;

        return $this;
    }

    /**
     * Get SupplierName
     *
     * @return string|null
     */
    public function getSupplierName()
    {
        return $this->SupplierName;
    }

    /**
     * Set PopUpMessage
     *
     * @param string|null $popupMessage
     * @return Materials
     */
    public function setPopUpMessage($popupMessage=null)
    {
        $this->PopUpMessage = $popupMessage;

        return $this;
    }

    /**
     * Get PopUpMessage
     *
     * @return string|null
     */
    public function getPopUpMessage()
    {
        return $this->PopUpMessage;
    }

    /**
     * Set CanIndent
     *
     * @param boolean $canIndent
     * @return Materials
     */
    public function setCanIndent($canIndent)
    {
        $this->canIndent = $canIndent;

        return $this;
    }

    /**
     * Get CanIndent value
     *
     * @return boolean
     */
    public function CanIndent()
    {
        return $this->canIndent;
    }

    // </editor-fold desc="Entity db properties accessors">

    // <editor-fold desc="Functions to override parent class">

    public function getItemEntity() {
        return __CLASS__;
    }

    // </editor-fold desc="Functions to override parent class">

}
