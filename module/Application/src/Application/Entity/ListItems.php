<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use \Doctrine\Common\Collections\Criteria;

/**
 * @ORM\Entity
 * @ORM\Table(name="ListItems")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 *      "item"       = "ListItems",
 *      "sublist"    = "Sublists",
 *      "subitem"    = "Subitems",
 *      "string"     = "Strings",
 *      "boolean"    = "Booleans",
 *      "material"   = "Materials",
 *      "printer"    = "Printers",
 *      "paper"      = "Papers"
 * })
 */
class ListItems implements GenericInterface
{

    // <editor-fold desc="Entity properties bound to db columns">

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
     * @ORM\Column(name="ListId", type="integer", nullable=true)
     */
    protected $ListId;

    /**
     * @var string
     *
     * @ORM\Column(name="EntityName", type="string", length=64, nullable=true)
     */
    protected $EntityName;

    /**
     * @var string $Comment
     *
     * @ORM\Column(name="Comment", type="string", length=128, nullable=true)
     */
    protected $Comment;

    /**
     * @var integer $priority;
     *
     * @ORM\Column(name="priority", type="integer", nullable=true)
     */

    protected $priority;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection $ItemOptions
     *
     * @ORM\OneToMany(targetEntity="Application\Entity\ItemOptions", mappedBy="ItemOptionId", cascade={"all"})
     */
    private $ItemOptions;

    /**
     * @var array $valid_options
     */
    private $valid_options = array();

    // </editor-fold desc="Entity properties bound to db columns">

    /**
     * @var \Application\Entity\Lists
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Lists")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ListId", referencedColumnName="ListId", onDelete="CASCADE")
     * })
     */
    protected $list;

    public function __construct() {
        $this->setEntityName(__CLASS__);
    }

    // <editor-fold desc="Entity db properties accessors">

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
     * Set Comment
     *
     * @param string|null $comment
     * @return Materials
     */
    public function setComment($comment=null)
    {
        $this->Comment = $comment;

        return $this;
    }

    /**
     * Get Comment
     *
     * @return string|null
     */
    public function getComment()
    {
        return $this->Comment;
    }

    /**
     * Set Priority (used in ordering list items)
     *
     * @param integer|null $priority
     * @return Materials
     */
    public function setPriority($priority=null)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get Priority
     *
     * @return string
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param string $ioDesc
     * @param boolean $val
     * @return Lists
     * @throws \Exception
     */
    public function setOption($ioDesc, $val) {
        $newOpt = new ItemOptions();
        $newOpt->setDescription($ioDesc);
        $newOpt->setContent($val);
        return $this->addItemOption($this->getId());
    }

    /**
     * Add ItemOption
     *
     * @param \Application\Entity\ItemOptions $itemoption
     * @return \Application\Entity\ListItems
     * @throws \Exception on invalid itemoption type
     */
    public function addItemOption(\Application\Entity\ItemOptions $itemoption)
    {
        if(!($itemoption instanceof ItemOptions) ) {
            throw new \Exception(__METHOD__ . " can only add instances of ItemOptions");
        }
        if(!in_array($itemoption->getDescription(), $this->valid_options)) {
            throw new \Exception(__METHOD__ . " invalid option '" . $itemoption->getDescription() . "'");
        } else {
            $this->removeItemOptionByDescription($itemoption->getDescription()); // only one option of any type should be included in the item array so remove any matching first
        }

        $itemoption->setItemrefId($this->getId());
        $this->ItemOptions->add($itemoption);

        return $this;
    }

    /**
     * clear the current list of all list items
     * @return \Application\Entity\ListItems
     */
    public function removeAllItemOptions() {
        foreach($this->ItemOptions->getIterator() as $itemOption) {
            $this->removeItemOption($itemOption);
        }
        return $this;
    }

    /**
     * Remove ItemOption
     *
     * @param \Application\Entity\ItemOptions $itemoption
     * @return \Application\Entity\ListItems
     */
    public function removeItemOption(\Application\Entity\ItemOptions $itemoption)
    {
        $this->ItemOptions->removeElement($itemoption);
        return $this;
    }

    /**
     * Remove ItemOption by description
     *
     * @param string $ioDesc
     */
    public function removeItemOptionByDescription($ioDesc)
    {
        $this->getOptions($ioDesc)->forAll( function($k, $itemOption) { $this->removeItemOption($itemOption); } );
    }

    /**
     * @param $ioDesc
     * @return \Application\Entity\ItemOptions
     */
    public function getOption($ioDesc) {
        return $this->getOptions($ioDesc)->current();
    }

    /**
     * @param $ioDesc
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getOptions($ioDesc) {
        $criteria = Criteria::create()->where(Criteria::expr()->eq("Description", $ioDesc));
        return $this->getItemOptions()->matching($criteria);
    }

    /**
     * Get ItemOptions
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getItemOptions()
    {
        return $this->ItemOptions;
    }

    // </editor-fold desc="Entity db properties accessors">

    // <editor-fold desc="Additional helper functions">

    /**
     * clear the list associations for this item
     */
    public function clearList() {
        $this->ListId = null;
        $this->list = null;
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
     * GenericInterface alias to get primary Id
     *
     * @return int
     */
    public function getId() {
        return $this->getListItemId();
    }

    // </editor-fold desc="Additional helper functions">

}
