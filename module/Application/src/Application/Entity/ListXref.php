<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ListXref
 *
 * @ORM\Table(name="ListXref")
 * @ORM\Entity
 */
class ListXref
{
    /**
     * @var integer
     *
     * @ORM\Column(name="listId", type="integer", nullable=false)
     */
    private $listId;

    /**
     * @var integer
     *
     * @ORM\Column(name="memberId", type="integer", nullable=false)
     */
    private $memberId;

    private $member;

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
     *   @ORM\JoinColumn(name="listId", referencedColumnName="listId")
     * })
     */
    private $list;


    /**
     * Set listId
     *
     * @param integer $listId
     * @return ListXref
     */
    public function setListId($listId)
    {
        $this->listId = $listId;

        return $this;
    }

    /**
     * Get listId
     *
     * @return integer 
     */
    public function getListId()
    {
        return $this->listId;
    }

    public function setMember($member) {
        $this->member = $member;
    }

    public function getMember() {
        return $this->member;
    }

    /**
     * Set memberId
     *
     * @param integer $memberId
     * @return ListXref
     */
    public function setMemberId($memberId)
    {
        $this->memberId = $memberId;

        return $this;
    }

    /**
     * Get memberId
     *
     * @return integer 
     */
    public function getMemberId()
    {
        return $this->memberId;
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
