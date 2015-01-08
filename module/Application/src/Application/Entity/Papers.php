<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Papers
 *
 * @ORM\Entity
 * @ORM\Table(name="Papers")
 */
class Papers extends ListItems
{
    /**
     * @var string
     *
     * @ORM\Column(name="PaperName", type="string", length=64, nullable=false)
     */
    protected $PaperName;

    /**
     * Get PaperId
     *
     * @return integer
     */
    public function getPaperId()
    {
        return $this->getMemberId();
    }

    /**
     * @param integer $paperId
     * @return ListXref
     */
    public function setPaperId($paperId) {
        return $this->setMemberId($paperId);
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
