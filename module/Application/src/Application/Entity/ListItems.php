<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="ListItems")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 *      "item"     = "ListItems",
 *      "sublist"  = "Sublists",
 *      "subitem"  = "Subitems",
 *      "val"      = "Vals",
 *      "material" = "Materials",
 *      "printer"  = "Printers",
 *      "paper"    = "Papers"
 * })
 */
class ListItems implements ListInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ListItemId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $ListItemId;

    /**
     * @var integer
     *
     * @ORM\Column(name="ListId", type="integer", nullable=false)
     */
    protected $ListId;

    /**
     * @var string
     *
     * @ORM\Column(name="EntityName", type="string", length=64, nullable=true)
     */
    protected $EntityName;

    /**
     * @var \Application\Entity\Lists
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Lists")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ListId", referencedColumnName="ListId")
     * })
     */
    protected $list;

    public function __construct() {
        $this->setEntityName(__CLASS__);
    }

    /**
     * Set ListId
     *
     * @param integer $listId
     * @return ListItems
     */
    public function setListId($listId)
    {
        $this->ListId = $listId;

        return $this;
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
     * Set EntityName
     *
     * @param string $entityName
     * @return ListItems
     */
    protected function setEntityName($entityName)
    {
        $this->EntityName = $entityName;

        return $this;
    }

    /**
     * Get EntityName
     *
     * @return string 
     */
    public function getEntityName()
    {
        return $this->EntityName;
    }

    /**
     * Get ListItemId
     *
     * @return integer 
     */
    public function getListItemId()
    {
        return $this->ListItemId;
    }

    /**
     * Set list
     *
     * @param \Application\Entity\Lists $list
     * @return ListItem
     */
    public function setList(\Application\Entity\Lists $list)
    {
        $this->setListId($list->getListId());
        $this->list = $list;

        return $this;
    }

    /**
     * Get list
     *
     * @return \Application\Entity\Lists 
     */
    public function getList()
    {
        return $this->list;
    }

    /**
     * ListInterface alias to get primary Id
     *
     * @return int
     */
    public function getId() {
        return $this->getListItemId();
    }
}
