<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sublists
 *
 * @ORM\Entity
 * @ORM\Table(name="Sublists")
 */
class Sublists extends ListItems
{
    /**
     * @var Lists $sublist
     */
    protected $sublist;

    /**
     * @var string
     *
     * @ORM\Column(name="ReflistId", type="string", length=64, nullable=false)
     */
    protected $ReflistId;

    public function __construct() {
        parent::__construct();
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
     * @param Lists|null $sublist
     * @return Sublists
     */
    public function setSubList(Lists $sublist = null)
    {
        if(is_null($sublist)) {
            if(isset($this->ReflistId) && (intval($this->ReflistId) > 0)) {

            }
        }
        $this->sublist = $sublist;

        return $this;
    }

    /**
     * @return Lists|null
     */
    public function getSubList()
    {
        return $this->sublist;
    }
}
