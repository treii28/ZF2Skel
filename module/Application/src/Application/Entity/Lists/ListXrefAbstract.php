<?php
/**
 * Created by PhpStorm.
 * User: scottw
 * Date: 12/31/14
 * Time: 2:47 PM
 */

namespace Application\Entity\Lists;

use Application\Entity\ListXref;

abstract class ListXrefAbstract extends ListXref {
    /**
     * @var \Doctrine\Common\Collections\Collection $members
     */
    private $members;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->initMembers();
        parent::__construct();
    }

    public function initMembers() {
        $this->members = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add member
     *
     * @param object $member
     * @return \Application\Entity\ListXref
     */
    public function addMember($member)
    {
        $this->members[] = $member;

        return $this;
    }

    /**
     * Remove member
     *
     * @param object $member
     */
    public function removeMember($member)
    {
        $this->members->removeElement($member);
    }

    /**
     * Get members
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMembers()
    {
        return $this->members;
    }
}