<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Values
 *
 * @ORM\Entity
 * @ORM\Table(name="Values", uniqueConstraints={
 *      @ORM\UniqueConstraint(name="UniqueValueId_idx", columns={"ValueId"}),
 *      @ORM\UniqueConstraint(name="UniqueValueName_idx", columns={"ValueName"})
 *   }
 * )
 */
class Values extends ListItems
{
    /**
     * legacy unique identifier
     *
     * @var integer
     *
     * @ORM\Column(name="ValueId", type="integer", nullable=true)
     */
    protected $ValueId;

    /**
     * @var string
     *
     * @ORM\Column(name="ValueName", type="string", length=64, nullable=false)
     */
    protected $ValueName;

    public function __construct() {
        parent::__construct();
        $this->setEntityName(__CLASS__);
    }

    /**
     * Get ValueId
     *
     * @return integer
     */
    public function getValueId()
    {
        return $this->ValueId;
    }

    /**
     * @param integer $valueId
     * @return ListXref
     */
    public function setValueId($valueId)
    {
        $this->ValueId = $valueId;

        return $this;
    }

    /**
     * Set ValueName
     *
     * @param string $valueName
     * @return Values
     */
    public function setValueName($valueName)
    {
        $this->ValueName = $valueName;

        return $this;
    }

    /**
     * Get ValueName
     *
     * @return string 
     */
    public function getValueName()
    {
        return $this->ValueName;
    }

    public function getItemEntity() {
        return __CLASS__;
    }
}
