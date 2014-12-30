<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lists
 *
 * @ORM\Table(name="Lists")
 * @ORM\Entity
 */
class Lists
{
    /**
     * @var integer
     *
     * @ORM\Column(name="typeId", type="integer", nullable=false)
     */
    private $typeId;

    /**
     * @var string
     *
     * @ORM\Column(name="listName", type="string", length=64, nullable=false)
     */
    private $listName;

    /**
     * @var integer
     *
     * @ORM\Column(name="listId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $listId;

    /**
     * @var \Application\Entity\Types
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Types")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="typeId", referencedColumnName="typeId")
     * })
     */
    private $type;


    /**
     * Set typeId
     *
     * @param integer $typeId
     * @return Lists
     */
    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;

        return $this;
    }

    /**
     * Get typeId
     *
     * @return integer 
     */
    public function getTypeId()
    {
        return $this->typeId;
    }

    /**
     * Set listName
     *
     * @param string $listName
     * @return Lists
     */
    public function setListName($listName)
    {
        $this->listName = $listName;

        return $this;
    }

    /**
     * Get listName
     *
     * @return string 
     */
    public function getListName()
    {
        return $this->listName;
    }

    /**
     * Get listId
     *
     * @return integer 
     */
    public function getListId()
    {
        return $this->listId;
    }

    /**
     * Set type
     *
     * @param \Application\Entity\Types $type
     * @return Lists
     */
    public function setType(\Application\Entity\Types $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \Application\Entity\Types 
     */
    public function getType()
    {
        return $this->type;
    }
}
