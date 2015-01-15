<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subitems
 *
 * @ORM\Entity
 * @ORM\Table(name="Subitems")
 */
class Subitems extends ListItems
{
    /**
     * @var \Application\Entity\ListItems $subitem
     */
    private $subitem;

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
     * @throws \Exception on invalid subItem
     */
    public function setSubitem(\Application\Entity\ListItems $subitem)
    {
        if(intval($subitem->getId()) > 0) {
            $this->setRefitemId($subitem->getId());
        } else {
            // this may occur if the subitem is not persisted (not yet stored in db with the doctrine entity manager)
            throw new \Exception(__METHOD__ . " subitem does not appear to contain a proper id");
        }
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
