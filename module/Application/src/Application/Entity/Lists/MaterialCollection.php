<?php

namespace Application\Entity\Lists;

//use Doctrine\ORM\Mapping as ORM;
use Application\Entity\Materials;

/**
 * MaterialCollection
 */
class MaterialCollection extends XrefAbstract
{
    /*
     * materials (members) relationship
     *
     * var \Doctrine\Common\Collections\Collection
     *
     * ORM\ManyToMany(targetEntity="Application\Entity\Materials", cascade={"all"})
     * ORM\JoinTable(name="Materials",
     *   joinColumns={
     *     ORM\JoinColumn(name="ListId", referencedColumnName="ListId", nullable=false)
     *   },
     *   inverseJoinColumns={
     *     ORM\JoinColumn(name="MemberId", referencedColumnName="MaterialId", columnDefinition="INT NULL")
     *   }
     * )
     */

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Set MaterialId
     *
     * @param integer $materialId
     * @return MaterialCollection
     */
    public function setMaterialId($materialId)
    {
        parent::setMemberId($materialId);

        return $this;
    }

    /**
     * Get MaterialId
     *
     * @return integer 
     */
    public function getMaterialId()
    {
        return parent::getMemberId();
    }

    public function initMaterials() {
        parent::initMembers();
    }

    /**
     * Add materials
     *
     * @param \Application\Entity\Materials $materials
     * @return MaterialCollection
     */
    public function addMaterial(Materials $materials)
    {
        return parent::addMember($materials);
    }

    /**
     * Remove materials
     *
     * @param \Application\Entity\Materials $materials
     */
    public function removeMaterial(Materials $materials)
    {
        parent::removeElement($materials);
    }

    /**
     * Get materials
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMaterials()
    {
        return parent::getMembers();
    }
}
