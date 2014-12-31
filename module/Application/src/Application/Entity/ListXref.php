<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ListXref
 *
 * @ORM\Table(name="ListXref", uniqueConstraints={@ORM\UniqueConstraint(name="ListMember_idx", columns={"ListId", "MemberId"})})
 * @ORM\Entity
 */
class ListXref
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ListId", type="integer", nullable=false)
     */
    private $ListId;

    /**
     * @var integer
     *
     * @ORM\Column(name="MemberId", type="integer", nullable=false)
     */
    private $MemberId;

    /**
     * @var integer
     *
     * @ORM\Column(name="listXrefId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $listXrefId;

    /**
     * @var \Application\Entity\Lists
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Lists")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ListId", referencedColumnName="ListId")
     * })
     */
    private $list;


    /**
     * Set ListId
     *
     * @param integer $listId
     * @return ListXref
     */
    public function setListId($listId)
    {
        $this->ListId = $listId;

        return $this;
    }

    /**
     * Get ListId
     *
     * @return integer 
     */
    public function getListId()
    {
        return $this->ListId;
    }

    /**
     * Set MemberId
     *
     * @param integer $memberId
     * @return ListXref
     */
    public function setMemberId($memberId)
    {
        $this->MemberId = $memberId;

        return $this;
    }

    /**
     * Get MemberId
     *
     * @return integer 
     */
    public function getMemberId()
    {
        return $this->MemberId;
    }

    /**
     * Get listXrefId
     *
     * @return integer 
     */
    public function getListXrefId()
    {
        return $this->listXrefId;
    }

    /**
     * Set list
     *
     * @param \Application\Entity\Lists $list
     * @return ListXref
     */
    public function setList(\Application\Entity\Lists $list = null)
    {
        $this->list = $list;

        return $this;
    }

    /**
     * Get list
     *
     * @return \Application\Entity\Lists 
     */
    public function getList()
    {
        return $this->list;
    }
}
