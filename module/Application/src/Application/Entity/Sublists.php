<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sublists
 *
 * @ORM\Entity
 * @ORM\Table(name="Sublists", uniqueConstraints={
 *      @ORM\UniqueConstraint(name="UniqueSublistId_idx", columns={"SublistId"}),
 *      @ORM\UniqueConstraint(name="UniqueReflistId_idx", columns={"ReflistId"})
 *   }
 * )
 */
class Sublists extends ListItems
{
    /**
     * @var \Application\Entity\Lists $sublist
     */
    protected $sublist;
    /**
     * legacy unique identifier
     *
     * @var integer
     *
     * @ORM\Column(name="SublistId", type="integer", nullable=true)
     */

    protected $SublistId;

    /**
     * @var string
     *
     * @ORM\Column(name="ReflistId", type="string", length=64, nullable=false)
     */
    protected $ReflistId;

    public function __construct() {
        parent::__construct();
        $this->setEntityName(__CLASS__);
    }

    /**
     * Get SublistId
     *
     * @return integer
     */
    public function getSublistId()
    {
        return $this->SublistId;
    }

    /**
     * @param integer $sublistId
     * @return ListItems
     */
    public function setSublistId($sublistId)
    {
        $this->SublistId = $sublistId;

        return $this;
    }

    /**
     * Set ReflistId
     *
     * @param string $reflistId
     * @return Sublists
     */
    public function setReflistId($reflistId)
    {
        $this->ReflistId = $reflistId;

        return $this;
    }

    /**
     * Get ReflistId
     *
     * @return string
     */
    public function getReflistId()
    {
        return $this->ReflistId;
    }

    public function getItemEntity() {
        return __CLASS__;
    }

    /**
     * set Sublist
     *
     * @param \Application\Entity\Lists $sublist
     * @return Sublists
     */
    public function setList(\Application\Entity\Lists $sublist)
    {
        $this->setSublistId($sublist->getListId());
        $this->sublist = $sublist;

        return $this;
    }

    /**
     * @return \Application\Entity\Lists|null
     */
    public function getList()
    {
        return $this->sublist;
    }
}
