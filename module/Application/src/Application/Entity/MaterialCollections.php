<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MaterialCollections
 *
 * @ORM\Table(name="MaterialCollections")
 * @ORM\Entity
 */
class MaterialCollections
{
    /**
     * @var string
     *
     * @ORM\Column(name="materialCollectionName", type="string", length=64, nullable=false)
     */
    private $materialCollectionName;

    /**
     * @var integer
     *
     * @ORM\Column(name="MaterialCollectionId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $materialCollectionId;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Application\Entity\Materials", cascade={"all"})
     * @ORM\JoinTable(name="MaterialCollectionMaterials",
     *   joinColumns={
     *     @ORM\JoinColumn(name="MaterialCollectionId", referencedColumnName="MaterialCollectionId", nullable=false)
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="MaterialId", referencedColumnName="MaterialId", columnDefinition="INT NULL")
     *   }
     * )
     */
    private $materials;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->materials = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set materialCollectionName
     *
     * @param string $materialCollectionName
     * @return MaterialCollections
     */
    public function setMaterialCollectionName($materialCollectionName)
    {
        $this->materialCollectionName = $materialCollectionName;

        return $this;
    }

    /**
     * Get materialCollectionName
     *
     * @return string 
     */
    public function getMaterialCollectionName()
    {
        return $this->materialCollectionName;
    }

    /**
     * Get materialCollectionId
     *
     * @return integer 
     */
    public function getMaterialCollectionId()
    {
        return $this->materialCollectionId;
    }

    /**
     * Add materials
     *
     * @param \Application\Entity\Materials $materials
     * @return MaterialCollections
     */
    public function addMaterial(\Application\Entity\Materials $materials)
    {
        $this->materials[] = $materials;

        return $this;
    }

    /**
     * Remove materials
     *
     * @param \Application\Entity\Materials $materials
     */
    public function removeMaterial(\Application\Entity\Materials $materials)
    {
        $this->materials->removeElement($materials);
    }

    /**
     * Get materials
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMaterials()
    {
        return $this->materials;
    }
}
