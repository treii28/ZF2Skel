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
     * @ORM\Column(name="typeName", type="string", length=64, nullable=false)
     */
    private $typeName;

    /**
     * @var string
     *
     * @ORM\Column(name="tableName", type="string", length=64, nullable=true)
     */
    private $tableName;

    /**
     * @var string
     *
     * @ORM\Column(name="entityName", type="string", length=64, nullable=true)
     */
    private $entityName;

    /**
     * @var integer
     *
     * @ORM\Column(name="typeId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $typeId;


    /**
     * Set typeName
     *
     * @param string $typeName
     * @return Types
     */
    public function setTypeName($typeName)
    {
        $this->typeName = $typeName;

        return $this;
    }

    /**
     * Get typeName
     *
     * @return string 
     */
    public function getTypeName()
    {
        return $this->typeName;
    }

    /**
     * Set tableName
     *
     * @param string $tableName
     * @return Types
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;

        return $this;
    }

    /**
     * Get tableName
     *
     * @return string 
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * Set entityName
     *
     * @param string $entityName
     * @return Types
     */
    public function setEntityName($entityName)
    {
        $this->entityName = $entityName;

        return $this;
    }

    /**
     * Get entityName
     *
     * @return string 
     */
    public function getEntityName()
    {
        return $this->entityName;
    }

    /**
     * Get typeId
     *
     * @return integer 
     */
    public function getTypeId()
    {
        return $this->typeId;
    }
}
