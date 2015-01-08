<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Types
 *
 * @ORM\Table(name="Types")
 * @ORM\Entity
 */
class Types
{
    /**
     * @var string
     *
     * @ORM\Column(name="TypeName", type="string", length=64, nullable=false)
     */
    private $TypeName;

    /**
     * @var integer
     *
     * @ORM\Column(name="TypeId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $TypeId;


    /**
     * Set TypeName
     *
     * @param string $typeName
     * @return Types
     */
    public function setTypeName($typeName)
    {
        $this->TypeName = $typeName;

        return $this;
    }

    /**
     * Get TypeName
     *
     * @return string 
     */
    public function getTypeName()
    {
        return $this->TypeName;
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
}
