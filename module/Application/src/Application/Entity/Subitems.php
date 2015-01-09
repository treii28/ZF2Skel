<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subitems
 *
 * @ORM\Entity
 * @ORM\Table(name="Subitems", uniqueConstraints={
 *      @ORM\UniqueConstraint(name="UniqueSubitemId_idx", columns={"SubitemId"}),
 *      @ORM\UniqueConstraint(name="UniqueRefitemId_idx", columns={"RefitemId"})
 *   }
 * )
 */
class Subitems extends ListItems
{
    /**
     * @var \Application\Entity\ListItems $subitem
     */
    private $subitem;

    /**
     * legacy unique identifier
     *
     * @var integer
     *
     * @ORM\Column(name="SubitemId", type="integer", nullable=true)
     */
    protected $SubitemId;

    /**
     * @var string
     *
     * @ORM\Column(name="RefitemId", type="string", length=64, nullable=false)
     */
    protected $RefitemId;

    public function __construct() {
        parent::__construct();
        $this->setEntityName(__CLASS__);
    }

    /**
     * Get SubitemId
     *
     * @return integer
     */
    public function getSubitemId()
    {
        return $this->SubitemId;
    }

    /**
     * @param integer $subitemId
     * @return ListItems
     */
    public function setSubitemId($subitemId)
    {
        $this->SubitemId = $subitemId;

        return $this;
    }

    /**
     * Set RefitemId
     *
     * @param string $refitemId
     * @return Subitems
     */
    public function setRefitemId($refitemId)
    {
        $this->RefitemId = $refitemId;

        return $this;
    }

    /**
     * Get RefitemId
     *
     * @return string 
     */
    public function getRefitemId()
    {
        return $this->RefitemId;
    }

    public function getItemEntity() {
        return __CLASS__;
    }

    /**
     * set Subitem
     *
     * @param \Application\Entity\ListItems $subitem
     * @return Subitems
     */
    public function setSubitem(\Application\Entity\ListItems $subitem)
    {
        $this->setSubitemId($subitem->getListItemId());
        $this->subitem = $subitem;

        return $this;
    }

    /**
     * @return \Application\Entity\ListItems|null
     */
    public function getSubitem()
    {
        return $this->subitem;
    }
}
