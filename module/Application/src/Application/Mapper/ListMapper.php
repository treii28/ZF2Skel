<?php
/**
 * Created by PhpStorm.
 * User: scottw
 * Date: 12/31/14
 * Time: 2:20 PM
 */

namespace Application\Mapper;

use Application\Entity\Lists;
use Zend\Mvc\Application;

class ListMapper extends AbstractMapper {

    const ENTITY_NAME = 'Application\\Entity\\Lists';

    /**
     * @var TypeMapper $_typeMapper
     */
    private $_typeMapper;

    /**
     * @var ListItemsMapper $_listitemsMapper
     */
    private $_listitemsMapper;

    /**
     * @param string $name
     * @return null|Lists
     */
    public function findRecordByName($name) {
        return $this->getRepo()->findOneBy(array('ListName' => $name));
    }

    /**
     * @param integer $id
     * @return null|Lists
     */
    public function getListById($id) {
        return $this->getRepo()->find($id);
    }

    public function populateListItems(\Application\Entity\Lists &$list) {
        $rawSubItems = $this->getListItemsMapper()->getRepo()->findBy(array('ListId' => $list->getListId()));
        $list->initListitems();
        foreach($rawSubItems as $subItem) {
            if($subItem instanceof \Application\Entity\Sublists) {
                $list->addListitem($this->getSublistRef($subItem->getSublistId()));
            } elseif($subItem instanceof \Application\Entity\Subitems) {
                $list->addListitem($this->getSubitemRef($subItem->getSubitemId()));
            } else {
                $list->addListitem($this->getItemRef($subItem->getItemId(), $subItem->getEntityName()));
            }
        }
    }

    /**
     * @param integer $subitemId
     * @return \Application\Entity\ListItems
     */
    private function getSubitemRef($subitemId) {
        $subItemRef = $this->getListItemsMapper()->getRepo()->findBy(array('SubitemId' => $subitemId));
        while(($subItemRef instanceof \Application\Entity\Subitems) || ($subItemRef instanceof \Application\Entity\Sublists)) {
            if($subItemRef instanceof \Application\Entity\Subitems) { // keep recursively following references with incursion of this method
                $subItemRef = $this->getSubitemRef($subItemRef->getSubitemId());
            }
            if($subItemRef instanceof \Application\Entity\Sublists) {
                $subItemRef = $this->$this->getRepo()->find($subItemRef->getSubitemId());
                $this->populateListItems($subList);
                return $subItemRef;
            }
        }

        return $this->getItemRef($subItemRef->getSubitemId(), $subItemRef->getEntityName());
    }

    /**
     * @param integer $itemId
     * @param string $entityName
     * @return \Application\Entity\ListItems|null
     */
    private function getItemRef($itemId,$entityName) {
        $refRepo = $this->getEntityManager()->getRepository($entityName);
        return $refRepo->find($itemId);
    }

    /**
     * @param integer $sublistId
     * @return \Application\Entity\Lists
     */
    private function getSublistRef($sublistId) {
        $subList = $this->getRepo()->find($sublistId);
        $this->populateListItems($subList);
        return $subList;
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
        $list = (intval($id > 0)) ? $this->findRecordById($id) : $this->findRecordByName($id);
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
     * @return ListItemsMapper
     */
    public function getListItemsMapper() {
        if(!($this->_listitemsMapper instanceof ListItemsMapper)) {
            $this->_listitemsMapper = $this->getServiceLocator()->get('ListItemsMapper');
        }
        return $this->_listitemsMapper;
    }
}