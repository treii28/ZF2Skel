<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Papers
 *
 * @ORM\Entity
 * @ORM\Table(name="Papers", uniqueConstraints={
 *      @ORM\UniqueConstraint(name="UniquePaperId_idx", columns={"PaperId"}),
 *      @ORM\UniqueConstraint(name="UniquePaperName_idx", columns={"PaperName"})
 *   }
 * )
 */
class Papers extends ListItems
{
    /**
     * legacy unique identifier
     *
     * @var integer
     *
     * @ORM\Column(name="PaperId", type="integer", nullable=true)
     */
    protected $PaperId;

    /**
     * @var string
     *
     * @ORM\Column(name="PaperName", type="string", length=64, nullable=false)
     */
    protected $PaperName;

    public function __construct() {
        parent::__construct();
        $this->setEntityName(__CLASS__);
    }

    /**
     * Get PaperId
     *
     * @return integer
     */
    public function getPaperId()
    {
        return $this->PaperId;
    }

    /**
     * @param integer $paperId
     * @return ListItems
     */
    public function setPaperId($paperId)
    {
        $this->PaperId = $paperId;

        return $this;
    }

    /**
     * Set PaperName
     *
     * @param string $paperName
     * @return Papers
     */
    public function setPaperName($paperName)
    {
        $this->PaperName = $paperName;

        return $this;
    }

    /**
     * Get PaperName
     *
     * @return string 
     */
    public function getPaperName()
    {
        return $this->PaperName;
    }

    /**
     * @return string
     */
    public function getItemEntity() {
        return __CLASS__;
    }
}
