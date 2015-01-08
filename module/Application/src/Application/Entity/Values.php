<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Values
 *
 * @ORM\Entity
 * @ORM\Table(name="Values")
 */
class Values extends ListItems
{
    /**
     * @var string
     *
     * @ORM\Column(name="ValueName", type="string", length=64, nullable=false)
     */
    protected $ValueName;

    /**
     * Get ValueId
     *
     * @return integer
     */
    public function getValueId()
    {
        return $this->getMemberId();
    }

    /**
     * @param integer $valueId
     * @return ListXref
     */
    public function setValueId($valueId) {
        return $this->setMemberId($valueId);
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
