<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lists
 *
 * @ORM\Table(name="Lists")
 * @ORM\Entity
 */
class Lists implements GenericInterface
{
    /**
     * @var integer $TypeId
     *
     * @ORM\Column(name="TypeId", type="integer", nullable=false)
     */
    private $TypeId;

    /**
     * @var string $ListName
     *
     * @ORM\Column(name="ListName", type="string", length=64, nullable=false)
     */
    private $ListName;

    /**
     * @var integer $ListId
     *
     * @ORM\Column(name="ListId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ListId;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection $Listitems
     *
     * @ORM\OneToMany(targetEntity="Application\Entity\ListItems", mappedBy="ListId", cascade={"all"})
     * @ORM\OrderBy({"priority" = "ASC"})
     */
    private $Listitems;

    /**
     * @var \Application\Entity\Types $type
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Types")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="TypeId", referencedColumnName="TypeId", onDelete="CASCADE")
     * })
     */
    private $type;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->initListitems();
    }

    public function initListitems() {
        $this->Listitems = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set TypeId
     *
     * @param integer $typeId
     * @return Lists
     */
    public function setTypeId($typeId)
    {
        $this->TypeId = $typeId;

        return $this;
    }

    /**
     * Get TypeId
     *
     * @return integer 
     */
    public function getTypeId()
    {
        return $this->TypeId;
    }

    /**
     * Set ListName
     *
     * @param string $listName
     * @return Lists
     */
    public function setListName($listName)
    {
        $this->ListName = $listName;

        return $this;
    }

    /**
     * Get ListName
     *
     * @return string 
     */
    public function getListName()
    {
        return $this->ListName;
    }

    /**
     * Get ListId
     *
     * @return integer 
     */
    public function getListId()
    {
        return $this->ListId;
    }

    /**
     * GenericInterface alias method for primary Id
     * @return int
     */
    public function getId() {
        return $this->getListId();
    }

    /**
     * Add Listitem
     *
     * @param \Application\Entity\ListItems $listitem
     * @return \Application\Entity\Lists
     * @throws \Exception on invalid listitem type
     */
    public function addListitem(\Application\Entity\ListItems $listitem)
    {
        if(!($listitem instanceof ListItems) ) {
            throw new \Exception(__METHOD__ . "can only add instances of ListItems");
        }
        $listitem->setList($this);
        $this->Listitems->add($listitem);

        return $this;
    }

    /**
     * Remove Listitem
     *
     * @param \Application\Entity\ListItems $listitem
     */
    public function removeListitem(\Application\Entity\ListItems $listitem)
    {
        $this->Listitems->removeElement($listitem);
        $listitem->clearList(); // NOTE: this orphans the item but does not delete it from the db
    }

    /**
     * Get Listitems
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getListitems()
    {
        return $this->Listitems;
    }

    /**
     * Set type
     *
     * @param \Application\Entity\Types $type
     * @return ListsElement
     */
    public function setType(\Application\Entity\Types $type = null)
    {
        $this->setTypeId($type->getTypeId());
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
