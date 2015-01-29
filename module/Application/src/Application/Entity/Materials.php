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
     * @var boolean $canIndent
     *
     * @ORM\Column(name="canIndent", type="boolean", options={"default":false}, nullable=false)
     */
    protected $canIndent;

    /**
     * @var boolean $canCutOut
     *
     * @ORM\Column(name="canCutOut", type="boolean", options={"default":false}, nullable=false)
     */
    protected $canCutOut;

    /**
     * @var boolean $canImprint
     *
     * @ORM\Column(name="canImprint", type="boolean", options={"default":false}, nullable=false)
     */
    protected $canImprint;

    /**
     * @var boolean $canEtch
     *
     * @ORM\Column(name="canEtch", type="boolean", options={"default":false}, nullable=false)
     */
    protected $canEtch;

    /**
     * @var boolean $canHaveCoverImage
     *
     * @ORM\Column(name="canHaveCoverImage", type="boolean", options={"default":false}, nullable=false)
     */
    protected $canHaveCoverImage;

    /**
     * @var boolean $isLeather
     *
     * @ORM\Column(name="isLeather", type="boolean", options={"default":false}, nullable=false)
     */
    protected $isLeather;

    /**
     * @var boolean $isDiscontinued
     *
     * @ORM\Column(name="isDiscontinued", type="boolean", options={"default":false}, nullable=false)
     */
    protected $isDiscontinued;

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

    /**
     * Set CanCutOut
     *
     * @param boolean $canCutOut
     * @return Materials
     */
    public function setCanCutOut($canCutOut)
    {
        $this->canCutOut = $canCutOut;

        return $this;
    }

    /**
     * Get CanCutOut value
     *
     * @return boolean
     */
    public function CanCutOut()
    {
        return $this->canCutOut;
    }

    /**
     * Set CanImprint
     *
     * @param boolean $canImprint
     * @return Materials
     */
    public function setCanImprint($canImprint)
    {
        $this->canImprint = $canImprint;

        return $this;
    }

    /**
     * Get CanImprint value
     *
     * @return boolean
     */
    public function CanImprint()
    {
        return $this->canImprint;
    }

    /**
     * Set CanEtch
     *
     * @param boolean $canEtch
     * @return Materials
     */
    public function setCanEtch($canEtch)
    {
        $this->canEtch = $canEtch;

        return $this;
    }

    /**
     * Get CanEtch value
     *
     * @return boolean
     */
    public function CanEtch()
    {
        return $this->canHaveCoverImage;
    }

    /**
     * Set CanHaveCoverImage
     *
     * @param boolean $canHaveCoverImage
     * @return Materials
     */
    public function setCanHaveCoverImage($canHaveCoverImage)
    {
        $this->canHaveCoverImage = $canHaveCoverImage;

        return $this;
    }

    /**
     * Get CanHaveCoverImage value
     *
     * @return boolean
     */
    public function CanHaveCoverImage()
    {
        return $this->canHaveCoverImage;
    }

    /**
     * Set IsLeather
     *
     * @param boolean $isLeather
     * @return Materials
     */
    public function setIsLeather($isLeather)
    {
        $this->isLeather = $isLeather;

        return $this;
    }

    /**
     * Get IsLeather value
     *
     * @return boolean
     */
    public function IsLeather()
    {
        return $this->isLeather;
    }

    /**
     * Set IsDiscontinued
     *
     * @param boolean $isDiscontinued
     * @return Materials
     */
    public function setIsDiscontinued($isDiscontinued)
    {
        $this->isDiscontinued = $isDiscontinued;

        return $this;
    }

    /**
     * Get IsDiscontinued value
     *
     * @return boolean
     */
    public function IsDiscontinued()
    {
        return $this->isDiscontinued;
    }

    // </editor-fold desc="Entity db properties accessors">

    // <editor-fold desc="Functions to override parent class">

    public function getItemEntity() {
        return __CLASS__;
    }

    // </editor-fold desc="Functions to override parent class">

}
