<?php
/**
 * Created by PhpStorm.
 * User: scottw
 * Date: 12/31/14
 * Time: 2:20 PM
 */

namespace Application\Mapper;

use Application\Entity\Lists;

class ListMapper extends AbstractMapper {

    const ENTITY_NAME = 'Application\\Entity\\Lists';

    /**
     * @var TypeMapper $_typeMapper
     */
    private $_typeMapper;

    /**
     * @var ListXrefMapper $_xrefMapper
     */
    private $_xrefMapper;

    /**
     * @param string $name
     * @return null|Lists
     */
    public function getListByName($name) {
        return $this->getRepo()->findOneBy(array('ListName' => $name));
    }

    /**
     * @param integer $id
     * @return null|Lists
     */
    public function getListById($id) {
        return $this->getRepo()->find($id);
    }

    /**
     * @param integer|string $id
     * @return array
     * @throws \Exception
     */
    public function getListsByType($id) {
        $type = (intval($id) > 0) ? $this->getTypeMapper()->findRecordById($id) : $this->getTypeMapper()->findRecordByName($id);
        if(!($type instanceof \Application\Entity\Types)) {
            throw new \Exception(__METHOD__ . " Type record not found for '$id'");
        }
        return $this->getRepo()->findBy(array('TypeId' => $type->getTypeId()));
    }

    /**
     * @param integer|string $id
     * @return string
     * @throws \Exception on list not found
     */
    public function getListTypeName($id) {
        $list = (intval($id > 0)) ? $this->getListById($id) : $this->getListByName($id);
        if(!($list instanceof Lists)) {
            throw new \Exception(__METHOD__ . " Lists record not found for '$id'");
        }
        return $list->getType()->getTypeName();
    }

    /**
     * @param integer|string $id
     * @return string
     * @throws \Exception on list not found
     */
    public function getListEntityName($id) {
        $list = (intval($id > 0)) ? $this->findRecordById($id) : $this->findRecordByName($id);
        if(!($list instanceof Lists)) {
            throw new \Exception(__METHOD__ . " Lists record not found for '$id'");
        }
        return 'Application\\Entity\\' . $list->getType()->getEntityName();
    }

    /**
     * @return TypeMapper
     */
    public function getTypeMapper()
    {
        if(!($this->_typeMapper instanceof TypeMapper)) {
            $this->_typeMapper = $this->getServiceLocator()->get('TypeMapper');
        }
        return $this->_typeMapper;
    }

    /**
     * @return ListXrefMapper
     */
    public function getListXrefMapper() {
        if(!($this->_xrefMapper instanceof ListXrefMapper)) {
            $this->_xrefMapper = $this->getServiceLocator()->get('ListXrefMapper');
        }
        return $this->_xrefMapper;
    }
    /**
     * @param \Application\Entity\Lists $listRef
     */
    public function populateListMembers(&$listRef) {
        $listRef->initMembers(); // clear the member array
        $listId = $listRef->getListId();
        $refRepo = $this->getListXrefMapper()->getRepo();
        $members = $refRepo->findBy(array('ListId' => $listId));
        foreach($this->getListXrefMapper()->getRepo()->findBy(array('ListId' => $listRef->getListId())) as $member) {
            $refEntity = 'Application\\Entity\\' . $listRef->getType()->getEntityName();
            $refRepo = $this->getEntityManager()->getRepository($refEntity);
            $memObj = $refRepo->find($member->getMemberId());
            if($memObj instanceof $refEntity) {
                $listRef->addMember($memObj);
            }
        }
    }
}